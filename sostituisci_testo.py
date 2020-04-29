#!/usr/bin/env python

#Gter copyleft

import os, fnmatch
def findReplace(directory, find, replace, filePattern):
    for path, dirs, files in os.walk(os.path.abspath(directory)):
        for filename in fnmatch.filter(files, filePattern):
            filepath = os.path.join(path, filename)
            with open(filepath) as f:
                s = f.read()
            s = s.replace(find, replace)
            with open(filepath, "w") as f:
                f.write(s)


findReplace("pages", "'/home/local/COMGE/egter01/emergenze-pcge_credenziali/conn.php'", "explode('emergenze-pcge',getcwd())[0].'emergenze-pcge/conn.php'", "*.php")