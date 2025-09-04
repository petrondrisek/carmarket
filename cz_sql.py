import os
import pymysql

mydb = pymysql.connect(
    host="",
    user="",
    password="",
    database=""
)
tablename = "cities"

def add_to_file(text):
    cursor = mydb.cursor()
    cursor.execute(text)
    mydb.commit()
    cursor.close()

if os.path.exists("./CZ.txt"):
    with open("./CZ.txt", "r", encoding="utf-8") as f:
        for line in f:
            columns = line.strip().split("\t")
            name = columns[1]
            aliases = "\", \"".join(columns[3].split(","))
            lat = columns[4]
            lng = columns[5]
            state = columns[8]
            add_to_file(f"INSERT INTO `{tablename}` (`name`, `aliases`, `state`, `lat`, `lng`, `created_at`, `updated_at`) VALUES (\"{name}\", JSON_ARRAY(\"{aliases}\"), \"{state}\", {lat}, {lng}, now(), now());")
else:
    print("File not found")

mydb.close()