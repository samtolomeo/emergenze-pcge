#! /usr/bin/env python
# -*- coding: utf-8 -*-

# Gter copyleft 2020
# Author: Roberto Marzocchi
# Script che interroga il DB MS-SQL dei manufatti, recupera l'ID del manufatto sulla base di:
# codvia, civico, colore e lettera 


import os, sys, re  # ,shutil,glob

import getopt  # per gestire gli input

import pymssql
import conn_mssql as c

import psycopg2
import conn as p
import requests

import token_api_ge as t

import xml.etree.ElementTree as et

from xml.etree.ElementTree import parse


def get_response_from_provider(token, IdSegnalazionePC, Descrizione, IdManufatto, CodViaDa, CivicoDa,
                               ColoreDa, LetteraDa):
    url = t.url
    # print(url)
    headers = {'Authorization': 'Bearer {}'.format(token),
               'content-type': 'text/xml'}
    body1 = """
    <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:goad="http://goadev.com/">
   <soap:Header/>
   <soap:Body>
      <goad:InserimentoSegnalazione>
         <!--Optional:-->
         <goad:manutenzioneSegnalazioneInput>
            <!--goad:IdTipologiaSegnalazione>7</goad:IdTipologiaSegnalazione-->
            <!--goad:IdModalitaSegnalazione>6</goad:IdModalitaSegnalazione-->
            <!--goad:IdSegnalante>ID_SEGNALANTE rimosso</goad:IdSegnalante-->
            <goad:IdManufatto>{0}</goad:IdManufatto>
            <!--Optional:-->
            <goad:Descrizione>{1}</goad:Descrizione>
            <goad:CodiceFonteEsterna>{2}</goad:CodiceFonteEsterna>
            <!--goad:IdTipologiaIntervento>21</goad:IdTipologiaIntervento-->
            <!--Optional:-->
            <!--goad:Matricola>emergenze</goad:Matricola-->
            <!--goad:MatricolaTitolare>76</goad:MatricolaTitolare-->
            <!--goad:CodiceUtilizzatoreTitolare>76</goad:CodiceUtilizzatoreTitolare-->
            <goad:CodViaDa>{3}</goad:CodViaDa>
            <!--Optional:-->
            <goad:CivicoDa>{4}</goad:CivicoDa>
            <!--Optional:-->
            <goad:ColoreDa>{5}</goad:ColoreDa>
            <!--Optional:-->
            <goad:LetteraDa>{6}</goad:LetteraDa>
         </goad:manutenzioneSegnalazioneInput>
         <!--Optional:-->
      </goad:InserimentoSegnalazione>
   </soap:Body>
</soap:Envelope>
    """.format(IdManufatto, Descrizione, IdSegnalazionePC, CodViaDa, CivicoDa, ColoreDa, LetteraDa)
    response = requests.post(url, data=body1, headers=headers)
    # print("Info recieved...")
    #print(response.content)
    root = et.fromstring(response.content)
    #print(root)
    # print('####################################################')
    id_segnalazione = root[0][0][0][1].text
    # id_segn = elem.attrib['IdSegnalazione']
    # print(id_segn)
    return response, id_segnalazione


def main():
    codvia = ''
    ncivico = ''
    colore = ''
    lettera = ''
    descrizione = ''
    try:
        opts, args = getopt.getopt(sys.argv[1:], "mv:n:c:l:d:i:",
                                   ["help", "via=", "ncivico=", "colore=", "lettera=", "descrizione="])
    except getopt.GetoptError:
        manual = 'emergenze2manutenzioni.py -v <codvia> -n <ncivico> -c <colore> -l <lettera> -d <descrizione> -i <id_segnalazione>'
        print(manual)
        sys.exit(2)
    for opt, arg in opts:
        if opt == '-m':
            print('manual')
            sys.exit()
        elif opt in ("-v", "--codvia"):
            codvia = arg
        elif opt in ("-n", "--ncivico"):
            ncivico = arg
        elif opt in ("-c", "--colore"):
            colore = arg
        elif opt in ("-l", "--lettera"):
            lettera = arg
        elif opt in ("-d", "--descrizione"):
            descrizione = arg
        elif opt in ("-i", "--id_segnalazione"):
            id_pc = arg
    if codvia == '':
        print('ERROR: codvia mancante')
        sys.exit()
    if ncivico == '':
        print('ERROR: ncivico mancante')
        sys.exit()
    if descrizione == '':
        print('ERROR: descrizione mancante')
        sys.exit()
    if id_pc == '':
        print('ERROR: descrizione mancante')
        sys.exit()
    con = psycopg2.connect(host=p.ip, dbname=p.db, user=p.user, password=p.pwd, port=p.port)
    cur = con.cursor()
    con.autocommit = True

    conn = pymssql.connect(server=c.server, user=c.user, password=c.password, database=c.database)
    cursor = conn.cursor()
    # query='SELECT id_manufatto, civico FROM VManufatti where codvia = 33760;'
    # query="SELECT ID_Manufatto, codvia FROM VIndirizziManufatti where codvia =33760 and civico='0104' and colore = 'R' and lettera is null;"
    query0 = "SELECT id_asta FROM geodb.civici where codvia = '{0}' and numero='{1}' ".format(codvia, ncivico)
    if colore == '':
        query = "{} and colore is null ".format(query0)
        lettera_ws = 'NULL'
    else:
        query = "{} and colore = '{}' ".format(query0, colore)
        lettera_ws = lettera
    if lettera == '':
        query = "{} and lettera is null;".format(query)
        lettera_ws = 'NULL'
    else:
        query = "{} and lettera = '{}';".format(query, lettera)
        lettera_ws = lettera
    # print(query)

    cur.execute(query)
    id_aste = cur.fetchall()
    # print("Print each row and it's columns values")
    for row in id_aste:
        id_asta = row[0]
    # print("id_asta={}".format(id_asta))

    query = "SELECT ID_Manufatto, codvia FROM VManufatti where id_oggetto_riferimento = {};".format(id_asta)
    cursor.execute(query)
    row = cursor.fetchone()
    while row:
        # print(str(row[0]) + " " + str(row[1]) + " " + str(row[2]))
        # print('id manufatto:{}'.format(row[0]))
        # print('codvia:{}'.format(row[1]))
        id_manufatto = row[0]
        # print('civico:{}'.format(row[2]))
        # print('id_asta:{}'.format(row[3]))
        row = cursor.fetchone()

    conn.close()
    con.close()

    token = t.token
    IdSegnalante = t.IdSegnalante
    risposta=[]
    risposta=get_response_from_provider(token, id_pc,  descrizione, id_manufatto, codvia, ncivico, colore, lettera)
    response = risposta[0]
    id_segnalazione = risposta [1]
    print(response.status_code)
    print(id_segnalazione)
    # print(response)
    if response.status_code == 200:
        # print('OK')
        return 200
    # ORA SI RICHIAMA IL WS


if __name__ == "__main__":
    main()
