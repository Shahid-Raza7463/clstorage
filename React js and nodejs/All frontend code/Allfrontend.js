
//*
//*
// Start hare 
// Start hare 
//*
// Start hare 
// Start hare 
//*  page link 
//*  page name OffersPage
// Start hare 
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import OffersTable from './OffersTable';

function OffersPage() {
    const [offersData, setOffersData] = useState([]);

    useEffect(() => {
        axios.get('http://localhost:5000/api/offers')  // Adjust the URL to your API endpoint
            .then(res => setOffersData(res.data))
            .catch(err => console.log(err));
    }, []);

    return (
        <div>
            <h1>Offers</h1>
            <OffersTable offersData={offersData} />
        </div>
    );
}

export default OffersPage;

//* OffersTable page 
// Start hare 

import React from 'react';
import { Link } from 'react-router-dom';

const OffersTable = ({ offersData }) => {

    const renderStatus = (status) => {
        if (status === 0) {
            return <span className="badge bg-danger">Inactive</span>;
        } else {
            return <span className="badge bg-success">Active</span>;
        }
    };

    return (
        <table className="table table-bordered table-hover table-darks" style={{ marginLeft: '20px' }}>
            <thead>
                <tr className="text-center">
                    <th>Title</th>
                    <th>Offer Id</th>
                    <th>Payout</th>
                    <th>Countries</th>
                    <th>Offer img</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {offersData.map((offer, index) => (
                    <tr key={index}>
                        <td>{offer.title}</td>
                        <td>{offer.offer_id}</td>
                        <td>{offer.payout}</td>
                        <td>
                            <div style={{ width: '58px', overflow: 'hidden', height: '56px' }}>
                                {offer.countries}
                            </div>
                        </td>
                        <td>{offer.offer_image}</td>
                        <td>
                            {renderStatus(offer.status)}
                        </td>
                        <td>
                            <div className="d-flex">
                                <div className="card-tools">
                                    <Link to={`/offers/${offer.id}/edit`} className="btn btn-sm btn-primary" style={{ height: '21px', width: '3rem', fontSize: '8px' }}>
                                        <i className="fa fa-pen"></i> Edit
                                    </Link>
                                </div>
                                <form action={`/admin/offers/${offer.id}`} method="post" className="form1">
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" className="deleteButton btn btn-sm btn-danger mx-2" onClick={(e) => { e.preventDefault(); showConfirmation(e); }} style={{ height: '21px', width: '3rem', fontSize: '8px' }}>
                                        <i className="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
};

export default OffersTable;

// Start hare 
//* regarding ternary oprater / condition / if statment 
// Start hare 
<td>
    {item.status === 0 ? (
        <span className="badge bg-danger">Inactive</span>
    ) : (
        <span className="badge bg-success">Active</span>
    )}
</td>
// Start hare 
// Start hare 
//* get data 
// Start hare
useEffect(() => {
    axios.get(`http://localhost:5000/users/${id}`)
        .then(res => {
            if (res.data.length > 0) {
                setUser(res.data[0]); // Assuming the response is an array
            } else {
                console.error('User not found');
            }
        })
        .catch(err => console.log(err));
}, [id]);
// Start hare 
const [networksData, setNetworksData] = useState([]);
const [commissionData, setCommissionData] = useState([]);
const [contactusData, setContactusData] = useState([]);
const [usersData, setUsersData] = useState([]);

useEffect(() => {
    // Call fetchData function for networks
    fetchData('http://localhost:5000/networks', setNetworksData);
    fetchData('http://localhost:5000/commission', setCommissionData);
    // Call fetchData function for contactus
    fetchData('http://localhost:5000/contactus', setContactusData);

    // Call fetchData function for users
    fetchData('http://localhost:5000/', setUsersData);
}, []);

const fetchData = async (url, setDataFunction) => {
    try {
        const response = await axios.get(url);
        setDataFunction(response.data);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

// after click join now button 
const handleJoin = (networkUrl) => {
    // Implement the logic for handling the join action here
    console.log("Join button clicked for network URL:", networkUrl);
    // For example, you can redirect the user to the network URL
    window.location.href = networkUrl;
};
// Start hare 
//* regarding edit 
// Start hare 

useEffect(() => {
    axios.get(`http://localhost:5000/editsoftware/${id}`)
        .then(res => {
            setEditSoftware(res.data);
            setName(res.data.name);
            // setEmail(res.data.email); 
            // setCount(res.data.count);
        })
        .catch(err => console.log(err));
}, [id]);

// Start hare 
//* regarding error file 
// Start hare 
import React, { useState } from 'react';
import axios from 'axios';

export default function CommissionForm() {
    const [name, setName] = useState('');
    const [errorMessage, setErrorMessage] = useState('');
    const [successMessage, setSuccessMessage] = useState('');

    const handleSubmit = async (event) => {
        event.preventDefault();
        try {
            const response = await axios.post('http://localhost:5000/commission', {
                name: name
            });
            setSuccessMessage(response.data.message);
            setName(''); // Clear the input field after successful submission
        } catch (error) {
            if (error.response) {
                setErrorMessage(error.response.data.error);
            } else {
                setErrorMessage('An error occurred. Please try again later.');
            }
        }
    };

    return (
        <div className="container mt-3">
            <div className="card card-default">
                <div className="card-header">
                    <h3 className="card-title mt-3">Commission Type</h3>
                    <div className="card-tools">
                        <a href="/commission" className="btn btn-sm btn-success"> All </a>
                    </div>
                </div>
                {errorMessage && (
                    <div className="alert alert-danger">
                        {errorMessage}
                    </div>
                )}
                {successMessage && (
                    <div className="alert alert-success">
                        {successMessage}
                    </div>
                )}
                <div className="form-Container m-3">
                    <form onSubmit={handleSubmit}>
                        <div className="row">
                            <div className="col-6 d-flex flex-column  mb-2">
                                <label htmlFor="name">Name:<span className="required">*</span></label>
                                <input
                                    className="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value={name}
                                    onChange={(e) => setName(e.target.value)}
                                    placeholder="Enter Name"
                                />
                                <span style={{ fontSize: '12px' }}>(Commission Type (CPA, CPL, CPI, CPS, RevShare, etc))</span>
                            </div>
                        </div>
                        <div className="row mt-3">
                            <div className="col-6">
                                <input type="submit" className="btn btn-success btn-md" name="submit" value="submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}

// Start hare 
//* regarding delete 
// Start hare 
const handleDelete = async (id) => {
    try {
        const url = `http://localhost:5000/admin/commissiontype/${id}`;
        console.log('DELETE request URL:', url);
        await axios.delete(`http://localhost:5000/admin/commissiontype/${id}`);
        // Update commissionData after deletion
        setCommissionData(commissionData.filter(item => item.id !== id));
        console.log('Item deleted successfully');
    } catch (error) {
        console.error('Error deleting item:', error);
    }
};

const handleDelete = async (id) => {
    try {
        // Log the constructed URL
        const url = `http://localhost:5000/admin/commissiontype/${id}`;
        console.log('DELETE request URL:', url);

        // Send DELETE request
        await axios.delete(url);

        // Update state after successful deletion
        setCommissionData(commissionData.filter(item => item.id !== id));
        console.log('Item deleted successfully');
    } catch (error) {
        console.error('Error deleting item:', error);
    }
};

// Start hare 
//* regarding console in function 
// Start hare 
const handleDelete = async (id) => {
    try {
        console.log(id);
        await axios.delete(`http://localhost:5000/admin/commissiontype/${id}`);
        setCommissionData(commissionData.filter(item => item.id !== id));
        console.log('Item deleted successfully');
    } catch (error) {
        console.error('Error deleting item:', error);
    }
};
// Start hare 
//* regarding console in blade file 
// Start hare 
{ console.log(item.id) }
console.log(editSoftware.name, 'hi');
console.log(res.data.name, 'hi');
// Start hare 
//*
// Start hare 
<div class="container mt-3">
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title mt-3">Commission Type</h3>
            <div class="card-tools">
                <a href="" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Add
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <table class="table table-bordered table-hover table-darks">
                        <tr>
                            <th>Select</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
// Start hare 
//*
// Start hare 
import Footer from '../Common/Footer';
import NavBar from '../Common/NavBar';
import TopAdspaces_1 from '../Adspaces/TopAdspaces_1';
import TopAdspaces_2 from '../Adspaces/TopAdspaces_2';
import TopAdspaces_3 from '../Adspaces/TopAdspaces_3';
<TopAdspaces_1 />
// Start hare 
//*
// Start hare 
.important - text {
    font - size: 23px!important;
}
style = {{ position: 'relative', height: '300px' }}
style = {{ minHeight: '250px', height: '250px', maxHeight: '250px', maxWidth: '100%' }}
style = {{ fontSize: '20px' }}
// Start hare 
//* regarding table data
// Start hare 
<table>
    <thead>
        <tr>
            <th>network_id</th>
            <th>network_name</th>
            <th>network_url</th>
        </tr>
    </thead>
    <tbody>
        {networksData.map((item, index) => (
            <tr key={index}>
                <td>{item.network_id}</td>
                <td>{item.network_name}</td>
                <td>{item.network_url}</td>
            </tr>
        ))}
    </tbody>
</table>
// Start hare 
//* regarding ratings
// Start hare 
// Assuming these calculations are done before rendering the JSX
const ratings = item.rating; // Replace with your rating value
const maxRating = 5; // Maximum rating value

const filledStars = Math.floor(ratings);
const hasHalfStar = ratings - filledStars >= 0.5;
const emptyStars = maxRating - filledStars - (hasHalfStar ? 1 : 0);

// Then use these variables in your JSX
<div className="mt-2 mx-3">
    <span className="badge join-badge">{item.rating}</span>
    <div className="table-rating d-flex">
        {/* Render Empty stars */}
        {[...Array(emptyStars)].map((_, index) => (
            <i key={index} className="fas fa-3x fa-star icon-color"></i>
        ))}
        {/* Render Half-star if present */}
        {hasHalfStar && <i className="fas fa-3x fa-star-half-alt"></i>}
        {/* Render Filled stars */}
        {[...Array(filledStars)].map((_, index) => (
            <i key={index} className="fas fa-3x fa-star"></i>
        ))}
    </div>
</div>

// Start hare 
//* regarding data display

// Start hare 
import React from 'react';

// TableRow component
const TableRow = ({ network }) => {
    return (
        <div className="d-flex justify-content-between">
            {/* Render network logo */}
            <img src={network.logo} className="img-fluid network-img rounded" />

            {/* Render network name and badge */}
            <div className="mx-4 mobile-div">
                <h6 className="prm-net">
                    <a href={network.network_url} className="text-dark">{network.network_name}</a>
                    {network.is_sponsored === 1 && (
                        <span className="badge spon-badge mx-1">Sponsored</span>
                    )}
                </h6>

                {/* Render icons */}
                <div className="table-icon">
                    {/* Render icons here */}
                </div>

                {/* Render text */}
                <div className="table-text mt-2">
                    <p>{network.review_count} Reviews / {network.affiliate_tracking_software} / {network.name}</p>
                </div>
            </div>

            {/* Render description */}
            <div className="desc-td">
                <p className="description mt-2">{network.network_description}</p>
            </div>

            {/* Render offer count */}
            <div className="m-offer">
                <p className="fw-bold off-text">{network.offer_count}</p>
            </div>

            {/* Render Join button */}
            <div className="m-td">
                <button type="button" className="btn table-btn mx-3" fdprocessedid="6sljwl">Join Now</button>
                <div className="mt-2 mx-3">
                    {/* Render rating component */}
                </div>
            </div>
        </div>
    );
};

// Container component
class NetworkTable extends React.Component {
    render() {
        const { networksData } = this.props;
        return (
            <div className="container mt-4">
                <div className="table-div">
                    <div className="d-flex justify-content-between head-div">
                        {/* Render table headers */}
                    </div>
                    {/* Render table rows */}
                    {networksData.map((network, index) => (
                        <TableRow key={index} network={network} />
                    ))}
                </div>
            </div>
        );
    }
}

export default NetworkTable;

// Start hare 
//*navbar / nav bar 
import React from 'react';
import { Link } from 'react-router-dom';

const NavBar = ({ setCurrentPage }) => {
    return (
        <nav>
            <ul>
                <li>
                    <Link to="/" onClick={() => setCurrentPage('home')}>
                        Home
                    </Link>
                </li>
                <li>
                    <Link to="/about" onClick={() => setCurrentPage('about')}>
                        About
                    </Link>
                </li>
                <li>
                    <Link to="/contact" onClick={() => setCurrentPage('contact')}>
                        Contact Us
                    </Link>
                </li>
            </ul>
        </nav>
    );
};

export default NavBar;

// import React from 'react';
import React, { useState, useEffect } from 'react';
import axios from 'axios';

const About = () => {


    const [data, setData] = useState([]);

    useEffect(() => {
        // call fetchData function 
        fetchData();
    }, []);


    // Get data on react app from nodejs route 5000
    const fetchData = async () => {
        try {
            const response = await axios.get('http://localhost:5000/contactus');
            setData(response.data);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };
    return (
        // <div>
        //   <h2>About Page</h2>
        //   <p>Learn more about us on the About Page.</p>
        // </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    {data.map((item, index) => (
                        <tr key={index}>
                            <td>{item.id}</td>
                            <td>{item.name}</td>
                            <td>{item.email}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default About;

//*app.js 
import React, { useState } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

import Home from './components/Home';
import About from './components/About';
import Contact from './components/Contact';
import NavBar from './components/navbar/NavBar';
import './App.css';

const App = () => {
    const [currentPage, setCurrentPage] = useState('home');

    return (
        <Router>
            <div>
                <NavBar setCurrentPage={setCurrentPage} />
                <hr />

                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/about" element={<About />} />
                    <Route path="/contact" element={<Contact />} />
                </Routes>
            </div>
        </Router>
    );
};

export default App;

//* data display from multiple table in one page 

import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Contact = () => {
    const [networksData, setNetworksData] = useState([]);
    const [contactusData, setContactusData] = useState([]);
    const [usersData, setUsersData] = useState([]);

    useEffect(() => {
        // Call fetchData function for networks
        fetchData('http://localhost:5000/networks', setNetworksData);

        // Call fetchData function for contactus
        fetchData('http://localhost:5000/contactus', setContactusData);

        // Call fetchData function for users
        fetchData('http://localhost:5000/', setUsersData);
    }, []);

    const fetchData = async (url, setDataFunction) => {
        try {
            const response = await axios.get(url);
            setDataFunction(response.data);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };

    return (
        <div>
            <h2>Data from Networks Table</h2>
            <p>Feel free to reach out to us!</p>

            <table>
                <thead>
                    <tr>
                        <th>network_id</th>
                        <th>network_name</th>
                        <th>network_url</th>
                    </tr>
                </thead>
                <tbody>
                    {networksData.map((item, index) => (
                        <tr key={index}>
                            <td>{item.network_id}</td>
                            <td>{item.network_name}</td>
                            <td>{item.network_url}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <h2>Data from contactus Table</h2>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    {contactusData.map((item, index) => (
                        <tr key={index}>
                            <td>{item.id}</td>
                            <td>{item.name}</td>
                            <td>{item.email}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
            <h2>Data from users Table</h2>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>email</th>
                    </tr>
                </thead>
                <tbody>
                    {usersData.slice(0, 10).map((item, index) => (
                        <tr key={index}>
                            <td>{item.id}</td>
                            <td>{item.name}</td>
                            <td>{item.email}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default Contact;

//* regarding data display / 
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>email</th>
        </tr>
    </thead>
    <tbody>
        {usersData.slice(0, 10).map((item, index) => (
            <tr key={index}>
                <td>{item.id}</td>
                <td>{item.name}</td>
                <td>{item.email}</td>
            </tr>
        ))}
    </tbody>
</table>
//* display data from database on react app
// import React from 'react';
import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Home = () => {

    const [data, setData] = useState([]);

    useEffect(() => {
        // call fetchData function 
        fetchData();
    }, []);


    // Get data on react app from nodejs route 5000
    const fetchData = async () => {
        try {
            const response = await axios.get('http://localhost:5000/');
            setData(response.data);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };




    return (
        // <div>
        //   <h2>Home Page</h2>
        //   <p>Welcome to the Home Page!</p>
        // </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    {data.map((item, index) => (
                        <tr key={index}>
                            <td>{item.name}</td>
                            <td>{item.address}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default Home;
