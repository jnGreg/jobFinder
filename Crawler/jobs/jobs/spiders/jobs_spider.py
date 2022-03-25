from email import header
from urllib import response
import scrapy
import json


class JobsSpider(scrapy.Spider):
    name='jobs'
    start_urls=['https://justjoin.it/api/offers']

    def parse(self, response):
        data=json.loads(response.body)
        list_of_links=[]
        [list_of_links.append('https://justjoin.it/api/offers/'+ data[i]['id']) for i,_ in enumerate(data)]

        with open("list_of_links.txt", 'w') as file:
            file.write('\n'.join(list_of_links))
        
        file.close()


