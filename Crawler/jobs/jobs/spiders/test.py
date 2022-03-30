import json
import requests





def readFile(fileName):
        fileObj = open(fileName, "r") 
        words = fileObj.read().splitlines() 
        fileObj.close()
        return words



def get_url_status(urls):  # checks status for each url in list urls
    
    for url in urls:
        try:
            print(url + " status: 200" )
            r = requests.get(url)
        except Exception as e:
            print(url + "\tNA FAILED TO CONNECT\t" + str(e))
            break
    return None

# Opening JSON file

f = open('Crawler\jobs\lista4.json')
new_links = json.load(f)
# Opening old txt file
old=readFile('Crawler\jobs\list_of_links_old.txt')


def is_new(new_links):
    new=[]
    for x in new:
        if x not in old:
            new.append(x)
        else:
            continue
    return new

def is_expired(old, new_links):
    expired=[]
    for x in old:
        if x not in new_links:
            expired.append(x)
        else:
            continue
        
expired=is_expired(old, new_links)
get_url_status()