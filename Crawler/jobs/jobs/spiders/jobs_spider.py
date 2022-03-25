from email import header
from urllib import response
import scrapy
import json


class JobsSpider(scrapy.Spider):
    name='jobs'
    start_urls=['https://justjoin.it/api/offers']

    def parse(self, response):
        data=json.loads(response.body)
        yield from  data
    