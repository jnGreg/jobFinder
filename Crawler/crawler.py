from datetime import datetime
import json
from datetime import datetime, timedelta
import pandas as pd
import urllib
from urllib.request import urlopen



def get_current_offers(url: str) -> None:
    req = urllib.request.Request(url, headers={'User-Agent': "Magic Browser"})
    response = urllib.request.urlopen(req)
    data_json = json.loads(response.read())

    with open("data/job_offers.json", 'w+') as f:
        json.dump(data_json, f)


# TODO id -> link -> parse body -> add describe offers_to_insert
def get_new_offers_to_insert(new_job_offers: list, current_id_status: pd.core.frame.DataFrame,
                             time_crawled: datetime):
    offers_to_insert = []
    new_id_status = []
    temp_new_id = [new_job_offers[index]['id'] for index, _ in enumerate(new_job_offers)]
    for index, new_id in enumerate(temp_new_id):
        if new_id in current_id_status['id'].values:
            # TODO jakos to co mam z tym co jest teraz czy jest to samo
            # offers_to_ver.append() -> tabelka -> kazdy row sprawdzic z uniq_id if inne dodaj if not pass
            new_id_status.append({'id': new_id,
                                  'status': 'active',
                                  'parsed_time': time_crawled,
                                  'display_offer': new_job_offers[index]['display_offer']})


        else:
            offers_to_insert.append(new_job_offers[index])
            new_id_status.append({'id': new_id,
                                  'status': 'active',
                                  'parsed_time': time_crawled,
                                  'display_offer': new_job_offers[index]['display_offer']})

    active = pd.DataFrame(new_id_status)

    active.to_csv('data/active.csv')
    offers_to_insert = pd.DataFrame(offers_to_insert)
    offers_to_insert.to_csv('data/offers_to_insert.csv')


def get_offers_id_expired(active: pd.core.frame.DataFrame,
                          expired_id_status: pd.core.frame.DataFrame) -> list:
    new_expired_id_status = []
    offers_id_to_update_status_to_expired = []

    for index, old_id in enumerate(current_id_status['id'].values):
        if old_id not in current_id_status['id'].values:
            offers_id_to_update_status_to_expired.append(old_id)
            new_expired_id_status.append(
                {'id': old_id,
                 'status': 'expired',
                 'parsed_time': current_id_status.loc[[index]]['parsed_time']})

    new_expired = pd.DataFrame(new_expired_id_status)
    print(new_expired)
    print('przed appended')
    if len(new_expired) > 0:
        expired_id_status.append(new_expired)

    expired_id_status
    print('przed zapisem')
    expired_id_status.to_csv('data/expired.csv')

    return offers_id_to_update_status_to_expired


# type  strig to list of dicts
def df_column_string_to_list(df: pd.core.frame.DataFrame, col_name: str) -> pd.core.frame.DataFrame:
    """2 columns id, and col in form of str([{}])"""
    temp_list_of_tuples = []

    for x in zip(df['offer_id'], df[col_name]):
        temp_list_of_tuples.append((x[0], list(eval(x[1]))))

    new_df = pd.DataFrame(temp_list_of_tuples, columns=['offer_id', col_name])
    return new_df


# Replace NaN by empty dict
def replace_nans_with_dict(series: pd.core.frame.DataFrame):
    for idx in series[series.isnull()].index:
        series.at[idx] = {}
    return series


# Explodes list and dicts
def df_explosion(df: pd.core.frame.DataFrame, col_name: str) -> pd.core.frame.DataFrame:
    if df[col_name].isna().any():
        df[col_name] = replace_nans_with_dict(df[col_name])

    df.reset_index(drop=True, inplace=True)

    df1 = pd.DataFrame(df.loc[:, col_name].values.tolist())

    df = pd.concat([df, df1], axis=1)

    df.drop([col_name], axis=1, inplace=True)

    return df


def create_offers_to_insert_location(offers_to_insert: pd.core.frame.DataFrame) -> pd.core.frame.DataFrame:
    jobs_locations = offers_to_insert[['offer_id', 'multilocation']]
    jobs_locations = df_column_string_to_list(jobs_locations, 'multilocation')
    jobs_locations = jobs_locations.explode('multilocation')
    jobs_locations.reset_index(drop=True, inplace=True)
    jobs_locations = df_explosion(jobs_locations, 'multilocation')
    #     jobs_locations=jobs_locations.merge(city_woj, left_on='city', right_on='nazwa miasta')
    #     jobs_locations.drop(['slug', 'city'], axis=1)
    return jobs_locations


def create_offers_to_insert_skills(offers_to_insert: pd.core.frame.DataFrame) -> pd.core.frame.DataFrame:
    jobs_skills = offers_to_insert[['offer_id', 'skills']]
    jobs_skills = df_column_string_to_list(jobs_skills, 'skills')
    jobs_skills = jobs_skills.explode('skills')
    jobs_skills.reset_index(drop=True, inplace=True)
    jobs_skills = df_explosion(jobs_skills, 'skills')
    return jobs_skills


def create_offers_to_insert_empl_type(offers_to_insert: pd.core.frame.DataFrame) -> pd.core.frame.DataFrame:
    jobs_empl_types = offers_to_insert[['offer_id', 'employment_types']]
    jobs_empl_types = df_column_string_to_list(jobs_empl_types, 'employment_types')
    jobs_empl_types = jobs_empl_types.explode('employment_types')
    jobs_empl_types.reset_index(drop=True, inplace=True)
    jobs_empl_types = df_explosion(jobs_empl_types, 'employment_types')
    jobs_empl_types = df_explosion(jobs_empl_types, 'salary')
    return jobs_empl_types


# Load data
get_current_offers(url = "https://justjoin.it/api/offers")

# Time
time_crawled = datetime.now()

# Crawled data
new_job_offers = json.load(open('data/job_offers.json'))
expired_id_status = pd.read_csv('data/expired.csv')
current_id_status = pd.read_csv('data/active.csv')

get_new_offers_to_insert(new_job_offers, current_id_status, time_crawled)
current_id_status = pd.read_csv('data/active.csv')
offers_id_to_update_status_to_expired = get_offers_id_expired(current_id_status, expired_id_status)

# CHwilowo

current_json = pd.json_normalize(new_job_offers)

## Raw data with uniq offers in csv format from 24.04 to 08.05
current_json.to_csv('data/temp_joboffers.csv')
offers_to_insert = pd.read_csv('data/temp_joboffers.csv')

if len(offers_to_insert) > 0:
    print('dziala')
    offers_to_insert.insert(0, 'offer_id', offers_to_insert['id'])
    #     locations=create_offers_to_insert_location(offers_to_insert)
    skills = create_offers_to_insert_skills(offers_to_insert)
    empl_type = create_offers_to_insert_empl_type(offers_to_insert)
    offers_to_insert = offers_to_insert.drop(
        ['Unnamed: 0', 'latitude', 'longitude', 'employment_types', 'skills', 'multilocation', 'id'], axis=1)

# TODO nie dziala naprawić sprawdzanie expired po czasie albio po czymś
# if zmianty to starszy na unactive młodszy active dla 1 jj_id 1 active
# if len(offers_id_to_update_status_to_expired)>0:
#     print('zmień id dla tego zawodnika')
#     print(offers_id_to_update_status_to_expired)


# import the module
from sqlalchemy import create_engine

# offers_to_insert=pd.read_csv('data/temp_offers_to_insert.csv')

# # create sqlalchemy engine
# engine = create_engine("mysql+pymysql://{user}:{pw}@localhost/{db}"
#                        .format(user="root",
#                                pw="",
#                                db="jobfinder"))
#
# # offers_to_insert=offers_to_insert.reset_index(drop=True)
#
# # offers_to_insert
# # offers_to_insert.to_sql('offers', con = engine, if_exists = 'append', chunksize = 1000, index= False)
#
#
# # empl_type.columns
#
# offers_to_insert.insert(0, 'jj_id', offers_to_insert['offer_id'])
# offers_to_insert = offers_to_insert.drop('offer_id', axis=1)
# offers_to_insert = offers_to_insert.reset_index(drop=True)
# offers_to_insert.to_sql('offers', con=engine, if_exists='append', chunksize=1000, index=False)
#
# skills.insert(0, 'jj_id', skills['offer_id'])
# skills = skills.drop('offer_id', axis=1)
# skills = skills.reset_index(drop=True)
# skills.to_sql('skills', con=engine, if_exists='append', chunksize=1000, index=False)
#
# empl_type.insert(0, 'jj_id', empl_type['offer_id'])
# empl_type = empl_type.drop('offer_id', axis=1)
# empl_type = empl_type.reset_index(drop=True)
# empl_type.to_sql('employment', con=engine, if_exists='append', chunksize=1000, index=False)



