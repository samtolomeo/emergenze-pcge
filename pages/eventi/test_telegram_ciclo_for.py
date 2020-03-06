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

import time
import datetime
import telepot



import config
# Il token è contenuto nel file config.py e non è aggiornato su GitHub per evitare utilizzi impropri
TOKEN=config.TOKEN

bot = telepot.Bot(TOKEN)
#per ora solo un test su Roberto
#chat_id= config.chat_id

conn = psycopg2.connect(host=ip, dbname=db, user=user, password=pwd, port=port)
curr = conn.cursor()
conn.autocommit = True
#test ciclo for
query_chat_id= "SELECT telegram_id from users.v_utenti_sistema where telegram_id !='' and telegram_attivo='t' and (id_profilo='1' or id_profilo ='2' or id_profilo ='3') and matricola_cf='MRZRRT84B01D969U';"
curr.execute(query_chat_id)
print(datetime.datetime.now())
print(query_chat_id)
lista_chat_id = curr.fetchall() 
#print("Print each row and it's columns values")
for row in lista_chat_id:
    chat_id=row[0]
    print(chat_id)
    i=0
    while i<20:
        i+=1
        bot.sendMessage(chat_id, "{} - Mando un belin di messaggio con telepot!".format(i))
