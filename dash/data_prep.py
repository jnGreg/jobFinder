import plotly.io as pio
import plotly.graph_objects as go
import pandas as pd
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import json
import re
import plotly.express as px
import plotly.graph_objects as go
import math
import warnings
warnings.filterwarnings("ignore", 'This pattern has match groups')
## Data prep to Sanky

jobs = pd.read_csv('data/joboffers.csv')

## Add custom Categories by re in title
jobs_front = jobs[jobs['title'].str.contains(r'(^[Ff]ront.*)') == 1]
jobs_front = jobs_front.reset_index()
jobs_front['Category'] = 'Frontend'

jobs_devops = jobs[jobs['title'].str.contains(r'(^[Dd]ev[Oo].*)') == 1]
jobs_devops = jobs_devops.reset_index()
jobs_devops['Category'] = 'Devops'

jobs_back = jobs[jobs['title'].str.contains(
    r'(^[Bb]ack.*)|(^[Ss]oftware Developer.*)|(^[Ss]oftware Engineer.*)|(^/[Ff]ront.*)|(^/[Ff]ulls.*)') == 1]
jobs_back = jobs_back.reset_index()
jobs_back['Category'] = 'Backend'

jobs_full = jobs[jobs['title'].str.contains(r'(^[Ff]ull.*)') == 1]
jobs_full = jobs_full.reset_index()
jobs_full['Category'] = 'Fullstack'

jobs_test = jobs[jobs['title'].str.contains(r'(^[Tt]est.*)') == 1]
jobs_test = jobs_test.reset_index()
jobs_test['Category'] = 'Testing'
#####
jobs_support = jobs[jobs['title'].str.contains(r'(^[Ss]upport.*)') == 1]
jobs_support = jobs_support.reset_index()
jobs_support['Category'] = 'Support'

jobs_mobile = jobs[jobs['title'].str.contains(r'(^[Mm]obile.*)') == 1]
jobs_mobile = jobs_mobile.reset_index()
jobs_mobile['Category'] = 'Mobile'

jobs_admin = jobs[jobs['title'].str.contains(r'(^[Aa]dmin.*)') == 1]
jobs_admin = jobs_admin.reset_index()
jobs_admin['Category'] = 'Administrator'

jobs_big = jobs[jobs['title'].str.count(r'(^[Bb]ig Data.*)') == 1]
jobs_big = jobs_big.reset_index()
jobs_big['Category'] = 'BigData'

job_offer_titles_no_uniq = pd.concat([jobs_front, jobs_devops, jobs_back,
                                      jobs_full, jobs_test, jobs_support,
                                      jobs_mobile, jobs_admin, jobs_big], axis=0, )


def df_column_string_to_list(df, col_name: str):
    """2 columns id, and col in form of str([{}])"""
    temp_list_of_tuples = []
    for x in zip(df['id'], df['Category'], df['marker_icon'], df['workplace_type'],
                 df['experience_level'], df['city'], df[col_name]):
        temp_list_of_tuples.append((x[0], x[1], x[2], x[3], x[4], x[5], list(eval(x[-1]))))

    new_df = pd.DataFrame(temp_list_of_tuples, columns=['id ', 'Category', 'marker_icon',
                                                        'workplace_type', 'experience_level', 'city', col_name])
    return new_df


# Replace NaN by empty dict
def replace_nans_with_dict(series):
    for idx in series[series.isnull()].index:
        series.at[idx] = {}
    return series


# Explodes list and dicts
def df_explosion(df, col_name: str):
    if df[col_name].isna().any():
        df[col_name] = replace_nans_with_dict(df[col_name])

    df.reset_index(drop=True, inplace=True)

    df1 = pd.DataFrame(df.loc[:, col_name].values.tolist())

    df = pd.concat([df, df1], axis=1)

    df.drop([col_name], axis=1, inplace=True)

    return df


jobs = job_offer_titles_no_uniq

jobs_skills = jobs[['id', 'marker_icon', 'Category', 'skills', 'workplace_type', 'experience_level', 'city']]
jobs_empl_types = jobs[
    ['id', 'marker_icon', 'Category', 'employment_types', 'workplace_type', 'experience_level', 'city']]

jobs_skills = df_column_string_to_list(jobs_skills, 'skills')
jobs_skills = jobs_skills.explode('skills')
jobs_skills.reset_index(drop=True, inplace=True)
jobs_skills = df_explosion(jobs_skills, 'skills')
jobs_skills

jobs_empl_types = df_column_string_to_list(jobs_empl_types, 'employment_types')
jobs_empl_types = jobs_empl_types.explode('employment_types')
jobs_empl_types.reset_index(drop=True, inplace=True)
jobs_empl_types = df_explosion(jobs_empl_types, 'employment_types')
jobs_empl_types = df_explosion(jobs_empl_types, 'salary')

job_offer_titles_no_uniq.to_csv('data/job_offer_titles_no_uniq.csv')

jobs_empl_types.to_csv('data/jobs_empl_types.csv')
df_empl_types = pd.read_csv("data/jobs_empl_types.csv")

temp_jobs = jobs_empl_types[jobs_empl_types["marker_icon"].isin(['java', 'c', 'javascript',
                                                                'php', 'python', 'net', 'mobile',
                                                                'scala', 'go', 'ruby'])]
temp_jobs = temp_jobs[temp_jobs["Category"].isin(['Backend', 'Devops',
                                                                'Frontend', 'Fullstack', 'Mobile', 'Testing'])]

temp_jobs
# obrobic dane - usunac nany, podzielic wg typu zatrudnienia
temp_earnings = jobs_empl_types[~np.isnan(jobs_empl_types["from"])]
temp_earnings = temp_earnings[temp_earnings['currency'] == 'pln']
temp_earnings

#jobs_empl_types
t_markers = set(temp_earnings.type)
#t_markers
t_ctgrs = set(temp_earnings.Category)
temp_earnings.drop(columns=['currency', 'marker_icon'])
e_markers = set(temp_earnings.type)
e_markers

temp_b2b = temp_earnings[temp_earnings['type'] == 'b2b']
temp_permanent = temp_earnings[temp_earnings['type'] == 'permanent']
temp_mandate = temp_earnings[temp_earnings['type'] == 'mandate_contract']

temp_b2b_junior=temp_b2b[temp_b2b['experience_level'] == 'junior']
temp_b2b_mid=temp_b2b[temp_b2b['experience_level'] == 'mid']
temp_b2b_senior=temp_b2b[temp_b2b['experience_level'] == 'senior']

temp_permanent_junior=temp_permanent[temp_permanent['experience_level'] == 'junior']
temp_permanent_mid=temp_permanent[temp_permanent['experience_level'] == 'mid']
temp_permanent_senior=temp_permanent[temp_permanent['experience_level'] == 'senior']

temp_mandate_junior=temp_mandate[temp_mandate['experience_level'] == 'junior']
temp_mandate_mid=temp_mandate[temp_mandate['experience_level'] == 'mid']
temp_mandate_senior=temp_mandate[temp_mandate['experience_level'] == 'senior']

temp_b2b_junior=temp_b2b_junior.pivot_table(index=['Category'],
                              values=['from','to'],
                      aggfunc='median').reset_index()
temp_b2b_mid=temp_b2b_mid.pivot_table(index=['Category'],
                              values=['from','to'],
                      aggfunc='median').reset_index()
temp_b2b_senior=temp_b2b_senior.pivot_table(index=['Category'],
                              values=['from','to'],
                      aggfunc='median').reset_index()

temp_permanent_junior=temp_permanent_junior.pivot_table(index=['Category'],
                              values=['from','to'],
                      aggfunc='median').reset_index()
temp_permanent_mid=temp_permanent_mid.pivot_table(index=['Category'],
                              values=['from','to'],
                      aggfunc='median').reset_index()
temp_permanent_senior=temp_permanent_senior.pivot_table(index=['Category'],
                              values=['from','to'],
                      aggfunc='median').reset_index()

temp_mandate_junior=temp_mandate_junior.pivot_table(index=['Category'],
                              values=['from','to'],
                      aggfunc='median').reset_index()
temp_mandate_mid=temp_mandate_mid.pivot_table(index=['Category'],
                              values=['from','to'],
                      aggfunc='median').reset_index()
temp_mandate_senior=temp_mandate_senior.pivot_table(index=['Category'],
                              values=['from','to'],
                      aggfunc='median').reset_index()




pio.templates.default = "plotly_white"

b2b = go.Figure()

b2b.add_trace(go.Scatter(x=temp_b2b_junior["from"],
                         y=temp_b2b_junior["Category"],
                         mode='markers',
                         marker_color='white',
                         marker_size=0,
                         name=''))

b2b.add_trace(go.Scatter(x=temp_b2b_junior["from"],
                         y=temp_b2b_junior["Category"],
                         mode='lines',
                         marker_color='DeepSkyBlue',
                         marker_size=20,
                         visible='legendonly',
                         name='junior'))

for i in range(len(temp_b2b_junior)):
    b2b.add_shape(type='line',
                  x0=temp_b2b_junior["from"][i],
                  y0=i,
                  x1=temp_b2b_junior["to"][i],
                  y1=i,
                  line=dict(color='DeepSkyBlue', width=8, dash="dot"))

for i in range(len(temp_b2b_junior)):
    b2b.add_shape(type='line',
                  x0=temp_b2b_junior["from"][i],
                  y0=i,
                  x1=temp_b2b_junior["to"][i],
                  y1=i,
                  line=dict(color='DeepSkyBlue', width=3))

b2b.add_trace(go.Scatter(x=temp_b2b_mid["from"],
                         y=temp_b2b_mid["Category"],
                         mode='lines',
                         marker_color='RoyalBlue',
                         marker_size=20,
                         visible='legendonly',
                         name='regular'))

for i in range(len(temp_b2b_mid)):
    b2b.add_shape(type='line',
                  x0=temp_b2b_mid["from"][i],
                  y0=i,
                  x1=temp_b2b_mid["to"][i],
                  y1=i,
                  line=dict(color='RoyalBlue', width=8, dash="dot"))

for i in range(len(temp_b2b_mid)):
    b2b.add_shape(type='line',
                  x0=temp_b2b_mid["from"][i],
                  y0=i,
                  x1=temp_b2b_mid["to"][i],
                  y1=i,
                  line=dict(color='RoyalBlue', width=3))

b2b.add_trace(go.Scatter(x=temp_b2b_senior["from"],
                         y=temp_b2b_senior["Category"],
                         mode='lines',
                         marker_color='Navy',
                         marker_size=20,
                         visible='legendonly',
                         name='senior'))

for i in range(len(temp_b2b_senior)):
    b2b.add_shape(type='line',
                  x0=temp_b2b_senior["from"][i],
                  y0=i,
                  x1=temp_b2b_senior["to"][i],
                  y1=i,
                  line=dict(color='Navy', width=8, dash="dot"))

for i in range(len(temp_b2b_senior)):
    b2b.add_shape(type='line',
                  x0=temp_b2b_senior["from"][i],
                  y0=i,
                  x1=temp_b2b_senior["to"][i],
                  y1=i,
                  line=dict(color='Navy', width=3))

b2b.update_layout(title='Poziom wynagrodzeń B2B w kategoriach wg seniority',
                  legend=dict(title='poziom doświadczenia'))
b2b.update_xaxes(title="rozpiętość oferowanych zarobków (PLN)", title_font=dict(size=15))

import plotly.io as pio

pio.templates.default = "plotly_white"

permament = go.Figure()

permament.add_trace(go.Scatter(x=temp_permanent_junior["from"],
                         y=temp_permanent_junior["Category"],
                         mode='markers',
                         marker_color='white',
                         marker_size=0,
                         name=''))

permament.add_trace(go.Scatter(x=temp_permanent_junior["from"],
                         y=temp_permanent_junior["Category"],
                         mode='lines',
                         marker_color='Tomato',
                         marker_size=20,
                         visible='legendonly',
                         name='junior'))

for i in range(len(temp_permanent_junior)):
    permament.add_shape(type='line',
                  x0=temp_permanent_junior["from"][i],
                  y0=i,
                  x1=temp_permanent_junior["to"][i],
                  y1=i,
                  line=dict(color='Tomato', width=7))

permament.add_trace(go.Scatter(x=temp_permanent_mid["from"],
                         y=temp_permanent_mid["Category"],
                         mode='lines',
                         marker_color='Crimson',
                         marker_size=20,
                         visible='legendonly',
                         name='regular'))

for i in range(len(temp_permanent_mid)):
    permament.add_shape(type='line',
                  x0=temp_permanent_mid["from"][i],
                  y0=i,
                  x1=temp_permanent_mid["to"][i],
                  y1=i,
                  line=dict(color='Crimson', width=7))

permament.add_trace(go.Scatter(x=temp_permanent_senior["from"],
                         y=temp_permanent_senior["Category"],
                         mode='lines',
                         marker_color='Maroon',
                         marker_size=20,
                         visible='legendonly',
                         name='senior'))

permament.add_trace(go.Scatter(x=temp_permanent_senior["from"],
                         y=temp_permanent_senior["Category"],
                         mode='markers',
                         marker_color='white',
                         marker_size=0,
                         name=''))

for i in range(len(temp_permanent_senior)):
    permament.add_shape(type='line',
                  x0=temp_permanent_senior["from"][i],
                  y0=i,
                  x1=temp_permanent_senior["to"][i],
                  y1=i,
                  line=dict(color='Maroon', width=7))

for i in range(len(temp_permanent_mid)):
    permament.add_shape(type='line',
                  x0=temp_permanent_mid["from"][i],
                  y0=i,
                  x1=temp_permanent_mid["to"][i],
                  y1=i,
                  line=dict(color='Crimson', width=6, dash="dot"))

for i in range(len(temp_permanent_junior)):
    permament.add_shape(type='line',
                  x0=temp_permanent_junior["from"][i],
                  y0=i,
                  x1=temp_permanent_junior["to"][i],
                  y1=i,
                  line=dict(color='Tomato', width=6, dash="dot"))

permament.update_layout(title='Poziom wynagrodzeń na UoP w kategoriach wg seniority',
                  legend=dict(title='poziom doświadczenia'))

permament.update_xaxes(title="rozpiętość oferowanych zarobków (PLN)", title_font=dict(size=15))