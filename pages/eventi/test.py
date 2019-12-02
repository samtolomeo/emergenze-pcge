#! /usr/bin/env python
# -*- coding: utf-8 -*-
#   Gter Copyleft 2018
#   Roberto Marzocchi

import os
#import urllib2 #problema con python3
import urllib.request
import xml.etree.ElementTree as et

import psycopg2
from conn import *
import datetime
import time

conn = psycopg2.connect(host=ip, dbname=db, user=user, password=pwd, port=port)
curr = conn.cursor()
conn.autocommit = True



query_chat_id= "SELECT telegram_id from users.v_utenti_sistema where telegram_id !='' and telegram_attivo='t' and (id_profilo='1' or id_profilo ='2' or id_profilo ='3');"
curr.execute(query_chat_id)
lista_chat_id = curr.fetchall() 
#print("Print each row and it's columns values")
for row in lista_chat_id:
    chat_id=row[0]
    print(chat_id)
    time.sleep(1)
