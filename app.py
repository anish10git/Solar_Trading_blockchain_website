from flask import Flask, render_template, request, redirect, url_for
from flask_mysqldb import MySQL

app = Flask(__name__)

# MySQL Configuration
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'solar_energy_db'
mysql = MySQL(app)

# Route for the buyer form
@app.route('/buyer_form', methods=['GET', 'POST'])
def buyer_form():
    if request.method == 'POST':
        buyer_name = request.form['buyer_name']
        aadhar_no = request.form['aadhar_no']
        eb_no = request.form['eb_no']
        phone_no = request.form['phone_no']

        # Insert data into the buyers table
        cur = mysql.connection.cursor()
        cur.execute("INSERT INTO buyers (buyer_name, aadhar_no, eb_no, phone_no) VALUES (%s, %s, %s, %s)",
                    (buyer_name, aadhar_no, eb_no, phone_no))
        mysql.connection.commit()
        cur.close()

        return redirect(url_for('home'))  # Redirect to home or any other page after form submission

    return render_template('buyer_form.html')

# Route for the seller form
@app.route('/seller_form', methods=['GET', 'POST'])
def seller_form():
    if request.method == 'POST':
        seller_name = request.form['seller_name']
        aadhar_no = request.form['aadhar_no']
        phone_no = request.form['phone_no']
        address = request.form['address']
        eb_no = request.form['eb_no']

        # Insert data into the sellers table
        cur = mysql.connection.cursor()
        cur.execute("INSERT INTO sellers (seller_name, aadhar_no, phone_no, address, eb_no) VALUES (%s, %s, %s, %s, %s)",
                    (seller_name, aadhar_no, phone_no, address, eb_no))
        mysql.connection.commit()
        cur.close()

        return redirect(url_for('home'))  # Redirect to home or any other page after form submission

    return render_template('seller_form.html')

@app.route('/bidding')
def bidding():
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM buy_requests")
    buy_requests = cur.fetchall()
    cur.close()

    return render_template('bidding.html', buy_requests=buy_requests)

@app.route('/log_book')
def log_book():
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM sell_transactions JOIN buy_transactions ON sell_transactions.id = buy_transactions.id")
    transactions = cur.fetchall()
    cur.close()

    return render_template('log_book.html', transactions=transactions)

if __name__ == '__main__':
    app.run(debug=True)
