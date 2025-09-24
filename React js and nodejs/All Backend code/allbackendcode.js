//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
//Start hare
//*
//Start hare
import React, { useState } from 'react';
import axios from 'axios';

export default function AddCommission() {
    const [name, setName] = useState('');
    const [location, setLocation] = useState('');

    const handleSubmit = async (event) => {
        event.preventDefault();
        try {
            await axios.post('http://localhost:5000/commission', { name, location });
            alert('Commission type added successfully');
            setName(''); // Clear the form after successful submission
            setLocation(''); // Clear the location input after successful submission
        } catch (error) {
            console.error('Error adding commission type:', error);
            alert('Failed to add commission type');
        }
    };

    return (
        <div>
            <form onSubmit={handleSubmit}>
                <label>
                    Name:
                    <input
                        type="text"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        required
                    />
                </label>
                <label>
                    Location:
                    <input
                        type="text"
                        value={location}
                        onChange={(e) => setLocation(e.target.value)}
                        required
                    />
                </label>
                <button type="submit">Submit</button>
            </form>
        </div>
    );
}
app.post("/commission", (req, res) => {
    const { name, location } = req.body;
    console.log('Received name:', name);
    console.log('Received location:', location);

    const query = "INSERT INTO commission_types (name, location) VALUES (?, ?)";
    con.query(query, [name, location], (err, result) => {
        if (err) {
            console.error('Error inserting commission type:', err);
            return res.status(500).json({ success: false, error: 'Internal Server Error' });
        }
        console.log('Inserted commission type:', result);
        return res.status(200).json({ success: true, message: 'Commission type added successfully' });
    });
});

//Start hare
//*
//Start hare
const url = 'http://localhost:5000/commission/' + name;
alert(url);
//Start hare
//* regarding postman
//Start hare

//Start hare
// create
http://localhost:5000/commission?id=7&name=sss
// methode post

// backend code 
app.post("/commission", (req, res) => {
    const id = req.query.id; // Get the id from URL parameters
    const name = req.query.name; // Get the name from URL parameters

    const query = "INSERT INTO commission_types (`id`, `name`) VALUES (?, ?)";
    const values = [id, name];

    con.query(query, values, (err, data) => {
        if (err) {
            console.error('Error inserting commission type:', err);
            return res.status(500).json({ success: false, error: 'Internal Server Error' });
        }
        return res.status(200).json({ success: true, message: 'Commission type added successfully' });
    });
});
//Start hare
// update 
http://localhost:5000/commission/update?id=7&name=NewName
// methode post

// backend code 
app.post("/commission/update", (req, res) => {
    const id = req.query.id; // Get the id from URL parameters
    const name = req.query.name; // Get the name from URL parameters

    // Construct the SQL query to update the commission type
    const query = "UPDATE commission_types SET name = ? WHERE id = ?";
    const values = [name, id];

    con.query(query, values, (err, data) => {
        if (err) {
            console.error('Error updating commission type:', err);
            return res.status(500).json({ success: false, error: 'Internal Server Error' });
        }
        return res.status(200).json({ success: true, message: 'Commission type updated successfully' });
    });
});
//Start hare
// Delete  
http://localhost:5000/commission/6
// methode Delete

// backend code 

app.delete("/commission/:id", (req, res) => {
    const commissionTypeId = req.params.id;
    const query = 'DELETE FROM commission_types WHERE id = ?';
    con.query(query, [commissionTypeId], (err, result) => {
        if (err) return res.json(err)
        return res.json("Commission type deleted successfully.")
    })
})
//Start hare
// edit functionality 
app.get("/commission/:id", (req, res) => {
    const commissionTypeId = req.params.id; // Get the ID from URL parameters

    // Construct the SQL query to fetch the commission type data by ID
    const query = "SELECT * FROM commission_types WHERE id = ?";

    con.query(query, [commissionTypeId], (err, result) => {
        if (err) {
            console.error('Error fetching commission type:', err);
            return res.status(500).json({ success: false, error: 'Internal Server Error' });
        }

        if (result.length === 0) {
            return res.status(404).json({ success: false, message: 'Commission type not found' });
        }

        // If a commission type with the given ID exists, return it in the response
        return res.status(200).json({ success: true, data: result[0] });
    });
});

//Start hare



//* mysql connection : its copy from 
// https://medium.com/@vishnukvka/crud-app-using-react-and-mysql-ddf19f032b40
//Start hare
import express from 'express'
import mysql from 'mysql'
import cors from 'cors'
import { Script } from 'vm';


const app = express()

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "root",
    database: "test"
})

// to send from html body
app.use(express.json())
app.use(cors())

app.get("/", (req, res) => {
    res.json("Hello World")
})

app.get("/book", (req, res) => {
    const q = "SELECT * FROM books"
    db.query(q, (err, data) => {
        if (err) return res.json(err)
        return res.json(data)
    })
})

app.listen(8800, () => {
    console.log("Connect to backend.")
})
//Start hare
//* regarding database / regarding join / regarding table 
//Start hare

app.get('/networks', (req, res) => {
    const query = `
        SELECT 
            n.network_id, n.network_name, n.network_type, n.network_url, 
            n.network_description, n.offer_count, n.min_payout, n.referral_commission, 
            n.affiliate_tracking_software, n.logo, n.review_count, n.rating, 
            n.tracking_link, n.is_sponsored, n.is_top_network, n.is_featured, 
            n.network_slug, n.status, nr.all_rating, nr.offer_rating, 
            nr.payout_rating, nr.tracking_rating, nr.support_rating, nr.review_text, 
            nr.review_img, nr.review_id, nr.created_at,
            GROUP_CONCAT(DISTINCT CONCAT(v.title, ':', v.icon)) AS verticals_titles,
            GROUP_CONCAT(DISTINCT nfl.name) AS name,
            GROUP_CONCAT(DISTINCT pl.name) AS payment_lists,
            GROUP_CONCAT(DISTINCT ct.name) AS commission_type
        FROM 
            networks AS n
        LEFT JOIN 
            network_review AS nr ON nr.network_id = n.network_id
        LEFT JOIN 
            network_verticals AS nv ON nv.network_id = n.network_id
        LEFT JOIN 
            verticals AS v ON nv.vertical_id = v.id
        LEFT JOIN 
            network_payout_frequency AS npf ON npf.network_id = n.network_id
        LEFT JOIN 
            net_frequency_lists AS nfl ON npf.payment_frequency = nfl.id
        LEFT JOIN 
            network_payment_method AS npm ON n.network_id = npm.network_id
        LEFT JOIN 
            payment_lists AS pl ON npm.payment_method = pl.id
        LEFT JOIN 
            networks_commission_type AS nct ON nct.network_id = n.network_id
        LEFT JOIN 
            commission_types AS ct ON nct.commission_type = ct.id
        GROUP BY 
            n.network_id
    `;

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});
//Start hare
app.get('/networks', (req, res) => {
    // const query = 'SELECT * FROM customers';
    const query = 'SELECT * FROM networks';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});
//Start hare
//* backend index.js file get through chatgpt
const express = require('express');
const cors = require('cors');
const mysql = require('mysql');

const app = express();

// Enable CORS for all routes
app.use(cors({
    origin: '*',
    methods: 'GET,HEAD,PUT,PATCH,POST,DELETE',
    preflightContinue: false,
    optionsSuccessStatus: 204,
    credentials: true,
    allowedHeaders: 'Content-Type,Authorization',
}));

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "expertaff"
});

con.connect(function (err) {
    if (err) {
        console.error('Error connecting to database:', err);
        throw err;
    }
    console.warn("Connected!");
});

// Handle cleanup when the server exits
process.on('exit', () => {
    con.end();
    console.log('Database connection closed.');
});

// Parse JSON requests
app.use(express.json());

// Find data in node js route 5000
app.get('/', (req, res) => {
    const query = 'SELECT * FROM users';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

// Find data in node js route 5000
app.get('/contactus', (req, res) => {
    const query = 'SELECT * FROM contactus';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

app.get('/networks', (req, res) => {
    const query = 'SELECT * FROM networks';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

// Dynamic port binding
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});

//* another way 
const express = require('express');
const cors = require('cors');
const mysql = require('mysql');

const app = express();

// Enable CORS for all routes
app.use(cors({
    origin: '*',
    methods: 'GET,HEAD,PUT,PATCH,POST,DELETE',
    preflightContinue: false,
    optionsSuccessStatus: 204,
    credentials: true,
    allowedHeaders: 'Content-Type,Authorization',
}));

const con = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    // database: "hero"
    database: "expertaff"
});

con.connect(function (err) {
    if (err) throw err;
    console.warn("Connected!");
});

// find data in node js routre 5000
app.get('/', (req, res) => {
    // const query = 'SELECT * FROM customers';
    const query = 'SELECT * FROM users';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

// find data in node js routre 5000
app.get('/contactus', (req, res) => {
    // const query = 'SELECT * FROM customers';
    const query = 'SELECT * FROM contactus';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});

app.get('/networks', (req, res) => {
    // const query = 'SELECT * FROM customers';
    const query = 'SELECT * FROM networks';

    con.query(query, (err, results) => {
        if (err) {
            console.error('Error executing query:', err);
            res.status(500).json({ error: 'Internal Server Error' });
            return;
        }

        res.json(results);
    });
});



// const PORT = process.env.PORT || 5000;

// app.listen(PORT, () => {
//     console.log(`Server is running on port ${PORT}`);
// });

app.listen(5000);