#! /usr/bin/env python
# -*- coding: utf-8 -*-

import xml.etree.ElementTree as ET
tree = ET.parse('testo.xml')
root = tree.getroot()



print(root)
print(root.tag)
print(root[0][0][0][1].text)
for element in root[0][0][0].findall("Body"):
    print(element)
