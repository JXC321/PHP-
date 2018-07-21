import requests
import re
from bs4 import BeautifulSoup
import pymysql

dbuser = ""
dbpassword = ""
dbdatabase = ""

def Load_date(date):
    #将数据写入数据库的函数
    cursor = db.cursor()
    sql = """insert into pro(title,description,pinput,poutput,psinput,psoutput) values("%s","%s","%s","%s","%s","%s");""" %(date[0],date[1],date[2],date[3],date[4],date[5])
    #print(sql)
    cursor.execute(sql)
    db.commit()
    
def quoterepl(matchobj):
    #将字符串中的双引号进行转义，便于写入数据库
    pattern = re.compile('"')
    return pattern.sub('\\"', matchobj.group(0))


main_url = "http://acm.hdu.edu.cn/showproblem.php?pid="
begin_index = 1000
db = pymysql.connect("localhost",dbuser,dbpassword,dbdatabase, use_unicode=True, charset="utf8")

for i in range(100):
    
    date = list()
    
    url = main_url + str(begin_index + i)
    #url = main_url + str(1040)
    res = requests.get(url)
    #print(res.text)
    Soup = BeautifulSoup(res.text,'lxml')
    Soup = Soup.select("tr > td['align=center']")[-1]
    title = Soup.select('h1')[0].text
    description = Soup.select('div["class=panel_content"]')[0:5]
    date.append(title)
    for s in description:
        s = s.text
        s = re.sub('.', quoterepl, s)
        date.append(s)

    #Load_date(date)
    try:
        Load_date(date)
        print("获取",str(begin_index+i),"成功！")
    except:
        print("获取",str(begin_index+i),"失败！")
    #break
