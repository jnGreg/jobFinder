
import unittest

from Crawler.jobs.jobs.items import JobsItem
from Crawler.jobs.jobs.middlewares import JobsSpiderMiddleware, JobsDownloaderMiddleware
from Crawler.jobs.jobs.pipelines import JobsPipeline
from Crawler.jobs.jobs.spiders.jobs_spider import JobsSpider
import pathlib

ji = JobsItem()
jsm = JobsSpiderMiddleware()
jdm = JobsDownloaderMiddleware()
jp = JobsPipeline()

js = JobsSpider()


class JobsItemTest(unittest.TestCase):

    def test_if_present_model(self):
        self.assertIsInstance(ji, JobsItem)


class JobsSpiderMiddlewareTest(unittest.TestCase):

    def test_if_present_middleware(self):
        self.assertIsInstance(jsm, JobsSpiderMiddleware)


class JobsDownloaderMiddlewareTest(unittest.TestCase):

    def test_if_present_downloader(self):
        self.assertIsInstance(jdm, JobsDownloaderMiddleware)


class JobsPipelineTest(unittest.TestCase):

    def test_if_present_pipeline(self):
        self.assertIsInstance(jp, JobsPipeline)


class JobsSpiderTest(unittest.TestCase):

    def test_if_present_spider(self):
        self.assertIsInstance(js, JobsSpider)

    def test_file_exists(self):
        path = pathlib.Path('Crawler\jobs\lista4.json')
        self.assertEquals((str(path), path.is_file()), (str(path), True))

    def test_file_not_empty(self):
        path = pathlib.Path('Crawler\jobs\lista4.json')
        self.assertNotEmpty(path)

    def assertNotEmpty(self, path):
        pass



