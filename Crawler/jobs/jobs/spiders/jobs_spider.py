from email import header
from urllib import response
import scrapy
import json


class JobsSpider(scrapy.Spider):
    name='jobs'
    start_urls=['https://justjoin.it/api/offers']

    def parse(self, response):
        data=json.loads(response.body)
        list_of_links=['https://justjoin.it/api/offers/'+ data[i]['id'] for i,_ in enumerate(data)]

        with open("lista4.json", 'w') as f:
            # indent=2 is not needed but makes the file human-readable 
            # if the data is nested
            json.dump(list_of_links, f, indent=2) 
        
        f.close()

