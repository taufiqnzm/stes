from datetime import datetime
from faker import Faker
import random
import mysql.connector
from mysql.connector import Error

# Function to insert data into the database
def insert_data(name, major, email, ic, phone, password, is_admin, pic, gender, position, posting_date, address):
    try:
        connection = mysql.connector.connect(
            host='localhost',
            database='stes',  # Your database name
            user='root',
            password=''  # Your database password
        )

        if connection.is_connected():
            cursor = connection.cursor()

            # Format the date correctly as 'YYYY-MM-DD'
            formatted_date = datetime.strptime(posting_date, '%d-%m-%Y').strftime('%Y-%m-%d')

            insert_query = """INSERT INTO Users
                            (name, major, email, ic, phone, pass, is_admin, pic, gender, position, posting_date, address)
                            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"""

            data = (name, major, email, ic, phone, password, is_admin, pic, gender, position, formatted_date, address)

            cursor.execute(insert_query, data)
            connection.commit()

    except Error as e:
        print("Error while connecting to MySQL", e)
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

# Generate and insert 50 random records
fake = Faker()

for _ in range(50):
    name = fake.name()
    major = fake.job()
    email = fake.email()
    ic = fake.ssn()
    phone = fake.phone_number()
    password = "123"  # Replace with the hashed password
    pic = "uploads/pic.jpg"  # Replace with the actual file path
    gender = random.choice(["male", "female"])
    position = random.choice(["Pengetua", "GPK Pentadbiran", "GPK Hem", "GPK Koku", "Guru", "Staff"])
    birthdate = fake.date_of_birth(minimum_age=22, maximum_age=65)
    posting_date = birthdate.strftime('%d-%m-%Y')  # Format the date as dd-mm-yyyy
    address = fake.address()  # Generates a random address

    insert_data(name, major, email, ic, phone, password, 0, pic, gender, position, posting_date, address)
