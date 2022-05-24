from dash import callback_context
import dash
import dash_daq as daq
from dash import dcc
from dash import html
import dash_bootstrap_components as dbc
import pandas as pd
import plotly.express as px
import base64
from dash.dependencies import Input, Output, State
import plotly.io as pio
import plotly.graph_objects as go
# from Objects import display_year, df_summary, chose_time, streak_pie, ranking
import random
import os
path = os.getcwd()
cwd=os.path.abspath(os.path.join(path, os.pardir))
from pathlib import Path
import warnings
warnings.filterwarnings("ignore", 'This pattern is interpreted as a regular expression, and has match groups. To actually get the groups, use str.extract.')
## Data prep to Sanky

from data_prep import permament, b2b

## LOAD DATA
jobs=pd.read_csv('data/joboffers.csv')
skills=pd.read_csv('data/job_offer_titles_no_uniq.csv')
remote = pd.read_csv('data/remote.csv')
df_friendly_pivot = pd.read_csv('data/df_friendly_pivot.csv')
df_marker_icon_seniority=pd.read_csv('data/df_marker_icon_seniority.csv')
n_buttons = ['7d', '30d', '90d', '1y', 'all']
## create figs

# remote
fig = px.pie(remote, values='count', names='remote', title='Możliwość pracy w pełni zdalnej', color='count')
colors = ['Crimson', 'PaleGreen']
fig.update_traces(textposition='inside', textfont_size=20, textinfo='percent+label', labels = ['nie', 'tak'],
                  marker=dict(colors=colors, line=dict(color='#000000', width=2)))
fig.update(layout_showlegend=False)
fig.update_layout(title_x=0.5)

# uk freindly
fig1 = px.pie(df_friendly_pivot, values='count', names='open_to_hire_ukrainians', title='Oferta otwarta dla obywateli Ukrainy', color='count')
colors = ['Crimson', 'PaleGreen']
fig1.update_traces(textposition='inside', textfont_size=20, textinfo='percent+label', labels = ['nie', 'tak'],
                  marker=dict(colors=colors, line=dict(color='#000000', width=2)))
fig1.update(layout_showlegend=False)
fig1.update_layout(title_x=0.5)

# senioity/ technology

fig2 = px.treemap(df_marker_icon_seniority, path=['marker_icon', 'experience_level'], values='liczba ofert',
                title='Udział poziomu specjalizacji w technlogiach',
                color='marker_icon')


#sankey



temp_jobs=skills

temp_jobs = skills[skills["marker_icon"].isin(['java', 'c', 'javascript',
                                                                'php', 'python', 'net', 'mobile',
                                                                'scala', 'go', 'ruby'])]


temp_jobs = temp_jobs[temp_jobs["Category"].isin(['Backend', 'Devops',
                                                                'Frontend', 'Fullstack', 'Mobile', 'Testing'])]


temp_ct=temp_jobs.pivot_table(index=['Category', 'marker_icon'],
                      aggfunc='count').reset_index()



# job_labels
category_uniq=list(temp_ct['Category'].unique())
marker_icons_uniq=list(temp_ct['marker_icon'].unique())
job_labels=category_uniq+[x for x in marker_icons_uniq]

## Exit
exits_temp=[]
list_of_exits_str=list(temp_ct['Category'])
for index,x in enumerate(category_uniq):
    for y in list_of_exits_str:
        if y==x:
            exits_temp.append(index)


## target
list_of_targets_str=list(temp_ct['marker_icon'])

n=0
target_temp=[]
for index,x in enumerate(marker_icons_uniq):
    for index2,y in enumerate(list_of_targets_str):
        if x==y:
            list_of_targets_str[index2]=index+len(category_uniq)

## job_values
job_values=[x for x in temp_ct['Unnamed: 0']]
wezly = {'label' : job_labels}

# Zdefiniowanie połaczeń
polaczenia = {'source' : exits_temp, 'target' : list_of_targets_str, 'value' : job_values}

# Zdefiniowanie danych diagramu
df = go.Sankey(link = polaczenia, node = wezly)

# Wyrysowanie diagramu
sankey = go.Figure(df)
sankey.update_layout(title = "Podział rynku ze względu na technologie")


########################################################################################################################
# =============================================================================
# ########## Style       ##########
# =============================================================================

SIDEBAR_STYLE = {
    "position": "fixed",
    "top": 0,
    "left": 0,
    "bottom": 0,
    "width": "20rem",
    "padding": "2rem 1rem",
    "background-color": '#35a744',
    'background': '#432874',
    'text': '#FFFFFF',
    'color:': '#FFFFFF',
    'font-family': ' Georgia , serif',
}

CARDS = {
    'height':'7vw',
    'textAlign': 'left',
    'font-weight': 'bold',
    'border-style': 'outset ',
    'background': '#edecee',
    'font-size': '1.95vw',
    'white-space': 'nowrap',
    'word-wrap': 'break-word',
    'border-radius': '4px',
    'margin-top': '5%',
    'margin-bottom': '5%',

}
# Liczby w Cardsach po call bakcach
CARDS2 = {
    'margin-bottom': '16%',
    'white-space': 'nowrap',
    'word-wrap': 'break-word',
    'font-size': '1vw',
    'text-align': 'Center'

}

CONTENT_STYLE = {
    'color': '',
    'background': '#e1e1e3',
    "margin-left": "21rem",
    "margin-right": "4rem",
    'font-family': 'Georgia , serif',
    "padding": "2rem 1rem", 'border-radius': '4px',
}

ROWS = {
    'padding': '1%',
}

COLS = {
    'background': '#edecee', 'border-radius': '4px',

}




# =============================================================================
# ########## Layout     ##########
# =============================================================================

##  DATE 7d, 30d,90d,1y,all
items = [
    dbc.Button("7 day", id='7d', value='df_7'),
    dbc.Button("30 days", id='30d', value='df_30'),
    dbc.Button("90 days", id='90d', value='df_90'),
    dbc.Button("1 year", id='1y', value='df_1Y'),
    dbc.Button("ALL", id='all', value='df')
]

# =============================================================================
# ########## CARDS    ##########
# =============================================================================


####### Ranga
rank = dbc.Card(
    [
        dbc.CardBody([
            html.P('Beginner', id='rank_current')],
        ),
    ], style=CARDS,

)

####### Value( aktualne)
value = dbc.Card(
    [
        dbc.CardBody([

            html.Div("Offer Number", style={'font-size': '1.25vw'}),
            html.Center(len(jobs), id='value')

        ]
        )
    ], style=CARDS
)
####### Value next rankup( aktualne)
rank_up = dbc.Card(
    [

        dbc.CardBody([

            html.Div("Lvl up: ", style={'font-size': '1.25vw'}),
            html.Center("-", id='rank_up')

        ]
        )

    ], style=CARDS,

)
####### AVG dla Value
avgv = dbc.Card(
    [
        dbc.CardBody([

            html.Div("Avg: ", style={'font-size': '1.25vw'}),
            html.Center("-", id='avg')

        ]
        )

    ],
    style=CARDS,
)

trend = dbc.Card(
    [

        dbc.CardBody([

            html.Div("Trend: ", style={'font-size': '1.25vw'}),
            html.Center("-", id='trend')

        ]
        )

    ],
    style=CARDS,
)
# MIn value
minor = dbc.Card(
    [
dbc.CardBody([

        html.Div("Min: ", style={'font-size': '1.25vw'}),
        html.Center("-", id='Min')
            ])
    ],
    style=CARDS,
)
# max vaLUE
maxor = dbc.Card(
    [

        dbc.CardBody([

            html.Div("Max: ", style={'font-size': '1.25vw'}),
            html.Center("-", id='Max')
        ])

    ],
    style=CARDS,
)
# date of smth
date = dbc.Card(
    [

        html.P("Date: "),
        html.P('-', id='data', style=CARDS2)

    ],
    style=CARDS,
)

# =============================================================================
# ########## SIDE BAR      ##########
# =============================================================================

side_bar = html.Div(
    [
        # html.Img(src='data:image/png;base64,{}'.format(habitica_logo)),
        html.H2("jobFinder Dashboard", className="display-5", style={
            'textAlign': 'rigth',
            'font-weight': 'bold',
            'color': '#ddd8e6',
            'font-size': '28px'
        }),
        html.Hr(),
        html.P(
            "Dashboard representing insights about IT job offers 24.04 - 06.05", className="lead",
            style={'textAlign': 'rigth',
                   'color': '#ddd8e6',
                   'font-size': '20px'
                   }
        ),
        html.Div('', style={'padding': 10}),
        html.Div([
                     html.H4('Category', style={'position': 'center',
                                                 'color': '#ddd8e6'}),
                     dcc.Dropdown(
                         id='demo-dropdown',
                         style={
                             'height': '5vh',
                             'width': '100%',
                             'position': 'top',
                             'textAlign': 'rigth',
                             'color': '#000000',
                             'font-size': '13px'
                         },
                         options=[
                             {"label": task_name, "value": task_name}
                             for task_name in jobs['marker_icon'].unique()
                         ],
                         value='None',
                         multi=False
                     ),
                     html.Div('', style={'padding': 10}),
                     html.H4('Date', style={'position': 'center',
                                            'color': '#ddd8e6'}),
                 ] + [dbc.Button("{}".format(i),value=None, id=str(i)) for i in n_buttons])
    ],
    style=SIDEBAR_STYLE,
)

# =============================================================================
# ########## CONTENT     ##########
# =============================================================================


content = html.Div(
    [html.Div('', style={'padding': 15}),

        html.Div('', style={'padding': 10}),
     html.Div([
         dbc.Row(
             [
                 dbc.Col(html.Div(dcc.Graph(id='my-graph1', figure=fig), style=COLS), width=4),
                 dbc.Col(html.Div(dcc.Graph(id='my-graph0', figure=fig2), style=COLS), width=8),
             ], style=ROWS, justify='start'
         ),

         dbc.Row(
             [
                 dbc.Col(html.Div(dcc.Graph(id='my-graph6', figure=fig1), style=COLS), width=4),
                 dbc.Col(html.Div(dcc.Graph(id='my-graph7', figure=sankey), style=COLS), width=8),
             ], style=ROWS, justify='start'
         ),
         # dbc.Row(
         #     [
         #         dbc.Col(html.Div(dcc.Graph(id='my-graph4', figure=display_year(z)), style=COLS), width=12),
         #     ], style=ROWS,
         # ),
         dbc.Row(
             [
                 dbc.Col(html.Div(dcc.Graph(id='my-graph8', figure=permament), style=COLS), width=6),
                 dbc.Col(html.Div(dcc.Graph(id='my-graph9', figure=b2b), style=COLS), width=6),
             ], style=ROWS, justify='start'
         ),
     ], style=CONTENT_STYLE)], style={'background': '#432874'})

# =============================================================================
# ########## SERVER      ##########
# =============================================================================

external_sheet = 'https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/pulse/bootstrap.min.css'

app = dash.Dash(__name__, prevent_initial_callbacks=True, external_stylesheets=[external_sheet])

app.layout = html.Div([dcc.Location(id="url"), content, side_bar])



app.run_server(debug=True)

