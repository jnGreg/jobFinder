#!/usr/bin/python
# -*- coding: utf-8 -*-

from datetime import datetime
import json
from datetime import datetime, timedelta
import pandas as pd
import urllib
from urllib.request import urlopen
import pymysql
from sqlalchemy import create_engine

def parse_new_offers(url: str) -> None:
    """get new json file from url """
    req = urllib.request.Request(url, headers={'User-Agent': "Magic Browser"})
    response = urllib.request.urlopen(req)
    data_json = json.loads(response.read())

    with open("data/job_offers.json", 'w+') as f:
        json.dump(data_json, f)


def get_new_active_offers():
    """get new offers to insert and create temp df offers to insert and get active offers id to update"""
    time_crawled = datetime.now()
    new_job_offers = json.load(open('data/job_offers.json'))
    current_active_id_status = pd.read_csv('data/current_active_id_status.csv')
    temp_new_id = [new_job_offers[index]['id'] for index, _ in enumerate(new_job_offers)]
    offers_to_insert = []
    offers_to_update = []
    new_active_id_status = []
    for index, new_id in enumerate(temp_new_id):
        if new_id in current_active_id_status['id'].values:
            offers_to_update.append(new_id)
            new_active_id_status.append({'id': new_id,
                                         'status': 'active',
                                         'parsed_time': time_crawled,
                                         'display_offer': new_job_offers[index]['display_offer']})


        else:
            offers_to_insert.append(new_job_offers[index])
            new_active_id_status.append({'id': new_id,
                                         'status': 'active',
                                         'parsed_time': time_crawled,
                                         'display_offer': new_job_offers[index]['display_offer']})

    active = pd.DataFrame(new_active_id_status)
    active.to_csv('data/current_active_id_status.csv')
    offers_to_insert = pd.DataFrame(offers_to_insert)
    offers_to_insert.to_csv('data/offers_to_insert.csv')

    offers_to_update = [str(x) for x in offers_to_update]

    return time_crawled, offers_to_update, offers_to_insert


def insert_data_parsed_information(offers_to_update, offers_to_insert) -> None:
    """insert into table information about number of active offer, new offer, last time parser"""

    connection = pymysql.connect(host='localhost',
                                 user='root',
                                 port='',
                                 password='',
                                 db='jobfinder',
                                 cursorclass=pymysql.cursors.DictCursor)
    try:

        with connection.cursor() as cursor:
            sqlQuery = f"""INSERT INTO `crawler_status` (time_parsed, active_len, new_len)
                          VALUES (CURRENT_TIMESTAMP(), {len(offers_to_update) + len(offers_to_insert)},{len(offers_to_insert)} )"""

            cursor.execute(sqlQuery)
            connection.commit()

    finally:
        connection.close()


def update_active_offer_time_parsed(offers_to_update) -> None:
    
    connection = pymysql.connect(host='localhost',
                                 user='root',
                                 port='',
                                 password='',
                                 db='jobfinder',
                                 cursorclass=pymysql.cursors.DictCursor)
    try:

        with connection.cursor() as cursor:
            sqlQuery = f"""
                            UPDATE offers
                            SET time_parsed = current_timestamp(), status='active'
                            WHERE jj_id IN {tuple(offers_to_update)};"""

            cursor.execute(sqlQuery)
            connection.commit()

    finally:
        connection.close()


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



def create_skills_to_insert(offers_to_insert: pd.core.frame.DataFrame) -> pd.core.frame.DataFrame:
    skills_to_insert = offers_to_insert[['offer_id', 'skills']]
    skills_to_insert = df_column_string_to_list(skills_to_insert, 'skills')
    skills_to_insert = skills_to_insert.explode('skills')
    skills_to_insert.reset_index(drop=True, inplace=True)
    skills_to_insert = df_explosion(skills_to_insert, 'skills')
    return skills_to_insert


def create_empl_type_to_insert(offers_to_insert: pd.core.frame.DataFrame) -> pd.core.frame.DataFrame:
    emply_type_to_insert = offers_to_insert[['offer_id', 'employment_types']]
    emply_type_to_insert = df_column_string_to_list(emply_type_to_insert, 'employment_types')
    emply_type_to_insert = emply_type_to_insert.explode('employment_types')
    emply_type_to_insert.reset_index(drop=True, inplace=True)
    emply_type_to_insert = df_explosion(emply_type_to_insert, 'employment_types')
    emply_type_to_insert = df_explosion(emply_type_to_insert, 'salary')
    return emply_type_to_insert


def insert_new_offers_skills_eply_type(offers_to_insert: pd.core.frame.DataFrame,
                                       skills_to_insert: pd.core.frame.DataFrame,
                                       emply_type_to_insert: pd.core.frame.DataFrame) -> None:

    engine = create_engine("mysql+pymysql://{user}:{pw}@localhost/{db}"
                           .format(user="root",
                                   pw="",
                                   db="jobfinder"))

    offers_to_insert.insert(0, 'jj_id', offers_to_insert['offer_id'])
    offers_to_insert = offers_to_insert.drop('offer_id', axis=1)
    offers_to_insert = offers_to_insert.reset_index(drop=True)
    offers_to_insert.to_sql('offers', con=engine, if_exists='append', chunksize=1000, index=False)

    skills_to_insert.insert(0, 'jj_id', skills_to_insert['offer_id'])
    skills_to_insert = skills_to_insert.drop('offer_id', axis=1)
    skills_to_insert = skills_to_insert.reset_index(drop=True)
    skills_to_insert.to_sql('skills', con=engine, if_exists='append', chunksize=1000, index=False)

    emply_type_to_insert.insert(0, 'jj_id', emply_type_to_insert['offer_id'])
    emply_type_to_insert = emply_type_to_insert.drop('offer_id', axis=1)
    emply_type_to_insert = emply_type_to_insert.reset_index(drop=True)
    emply_type_to_insert.to_sql('employment', con=engine, if_exists='append', chunksize=1000, index=False)


def update_offers_city_category_voivode_id():
    connection = pymysql.connect(host='localhost',
                                 user='root',
                                 port='',
                                 password='',
                                 db='jobfinder',
                                 cursorclass=pymysql.cursors.DictCursor)
    try:

        with connection.cursor() as cursor:
            sqlQuery = f"""
                    UPDATE offers 
                    SET city_id =(SELECT city_id FROM cities WHERE offers.city=cities.city AND offers.city_id IS NULL),
                        voivodeship_id=(SELECT voivodeship_id FROM cities WHERE offers.city=cities.city AND offers.voivodeship_id IS NULL)"""

            cursor.execute(sqlQuery)
            sqlQuery1 = f"""
                    UPDATE offers 
                    SET city_id = 0,
                        voivodeship_id=0
                    WHERE city_id is NULL
                    """
            cursor.execute(sqlQuery1)


            sqlQuery2 = f"""
                    UPDATE offers 
                    SET ctgr_id=(SELECT ctgr_id FROM ctgrs WHERE offers.marker_icon=ctgrs.category )"""
            cursor.execute(sqlQuery2)

            sqlQuery2 = f"""
                    UPDATE offers 
                    SET status='active'
                    WHERE status IS NULL """
            cursor.execute(sqlQuery2)

            connection.commit()

    finally:
        connection.close()

def update_expired_offer_time_parsed() -> None:
    connection = pymysql.connect(host='localhost',
                                 user='root',
                                 port='',
                                 password='',
                                 db='jobfinder',
                                 cursorclass=pymysql.cursors.DictCursor)
    try:

        with connection.cursor() as cursor:
            sqlQuery = f"""
                    UPDATE offers
                    SET status='expired'
                    WHERE NOT time_parsed BETWEEN SYSDATE() - INTERVAL 2 HOUR AND SYSDATE(); """

            cursor.execute(sqlQuery)
            connection.commit()

    finally:
        connection.close()

def arch_expired_offers() -> None:
    connection = pymysql.connect(host='localhost',
                                 user='root',
                                 port='',
                                 password='',
                                 db='jobfinder',
                                 cursorclass=pymysql.cursors.DictCursor)
    try:

        with connection.cursor() as cursor:
            sqlQuery = f"""
                    INSERT INTO expired_offers
                    SELECT * FROM offers
                    WHERE status='expired'; """
            cursor.execute(sqlQuery)

            sqlQuery1 = f"""
                    DELETE FROM offers
                    WHERE status ='expired'; """
            cursor.execute(sqlQuery1)

            connection.commit()

    finally:
        connection.close()


def main():
    parse_new_offers(url="https://justjoin.it/api/offers")
    time_crawled, offers_to_update, offers_to_insert = get_new_active_offers()
    insert_data_parsed_information(offers_to_update, offers_to_insert)
    update_active_offer_time_parsed(offers_to_update)

    offers_to_insert=pd.read_csv('data/offers_to_insert.csv')
    offers_to_insert = offers_to_insert.drop(['Unnamed: 0'], axis=1)

    if len(offers_to_insert) > 0:
        offers_to_insert.insert(0, 'offer_id', offers_to_insert['id'])
        skills_to_insert = create_skills_to_insert(offers_to_insert)
        emply_type_to_insert = create_empl_type_to_insert(offers_to_insert)
        offers_to_insert = offers_to_insert.drop(
            ['latitude', 'longitude', 'employment_types', 'skills', 'multilocation', 'id'], axis=1)
        insert_new_offers_skills_eply_type(offers_to_insert, skills_to_insert, emply_type_to_insert)

    update_offers_city_category_voivode_id()
    update_expired_offer_time_parsed()

if __name__ == '__main__':
    main()
