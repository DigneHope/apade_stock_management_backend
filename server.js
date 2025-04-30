
const express = require('express');
const app = express();
const cors = require('cors');
const bodyParser = require('body-parser');
const mysql = require('mysql');
const path = require('path');

app.use(cors());
app.use(bodyParser.json());


const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',  
  database: 'stock'
});


db.connect((err) => {
  if (err) throw err;
  console.log('Connected to MySQL database!');
});


app.get('/get-users', (req, res) => {
  const query = 'SELECT * FROM users';
  db.query(query, (err, results) => {
    if (err) {
      res.status(500).json({ message: 'Error fetching users', error: err });
    } else {
      res.status(200).json(results);
    }
  });
});


app.post('/login', (req, res) => {
  const { username, password } = req.body;
  
  const query = `SELECT * FROM users WHERE username = ? AND password = ?`;
  db.query(query, [username, password], (err, results) => {
    if (err) {
      res.status(500).json({ message: 'Error checking login', error: err });
    } else if (results.length > 0) {
      res.status(200).json({ message: 'Login successful!', user: results[0] });
    } else {
      res.status(401).json({ message: 'Invalid credentials' });
    }
  });
});

const PORT = 5000;
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});






