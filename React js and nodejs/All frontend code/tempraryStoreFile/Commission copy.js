// import React from 'react';
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

import Sidebar from '../About/Sidebar';

export default function Commission() {

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


  return (

    <div className="wrapper">
      <nav className="main-header navbar navbar-expand navbar-white navbar-light">
        <ul className="navbar-nav">
          <li className="nav-item">
            <a className="nav-link" data-widget="pushmenu" href="#" role="button"><i className="fas fa-bars"></i></a>
          </li>
        </ul>
      </nav>

      {/* sidebar menu */}
      <aside className="main-sidebar sidebar-dark-primary elevation-4">
        {/* <!-- Brand Logo --> */}
        <a href="index3.html" className="brand-link">
          <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" className="brand-image img-circle elevation-3" style={{ opacity: '.8' }} />
          <span className="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        {/* <!-- Sidebar --> */}
        <div className="sidebar">
          {/* <!-- Sidebar user panel (optional) --> */}
          <div className="user-panel mt-3 pb-3 mb-3 d-flex">
            <div className="image">
              <img src="dist/img/user2-160x160.jpg" className="img-circle elevation-2" alt="User Image" />
            </div>
            <div className="info">
              <a href="#" className="d-block">Alexander Pierce</a>
            </div>
          </div>

          {/* <!-- SidebarSearch Form --> */}
          <div className="form-inline">
            <div className="input-group" data-widget="sidebar-search">
              <input className="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" />
              <div className="input-group-append">
                <button className="btn btn-sidebar">
                  <i className="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>

          {/* <!-- Sidebar Menu --> */}
          <nav className="mt-2">
            <Sidebar />
          </nav>
        </div>
      </aside>

      {/* Content goes to hare */}
      <div className="content-wrapper">
        <section className="content">
          {/* <div className="container-fluid"> */}
          {/* content goes to hare  */}
          <div className="container mt-3">
            <div className="card card-default">
              <div className="card-header">
                <h3 className="card-title mt-3">Commission Type</h3>
                <div className="card-tools">
                  <a href="" className="btn btn-sm btn-success">
                    <i className="fa fa-plus"></i> Add
                  </a>
                </div>
              </div>

              <div className="card-body">
                <div className="table-responsive">
                  <table className="table table-bordered table-hover table-darks" style={{ marginLeft: '20px' }}>
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      {commissionData.map((item, index) => (
                        <tr key={index}>
                          <td>{item.id}</td>
                          <td>{item.name}</td>
                          <td>
                            <div className="d-flex">
                              <div className="card-tools">
                                <a href=""
                                  className="btn btn-sm btn-primary">
                                  <i className="fa fa-pen"></i> Edit
                                </a>
                              </div>
                              <form action="" method="post"
                                className="form1">
                                <button type="submit" className="deleteButton btn btn-sm btn-danger mx-2"
                                  onclick="showConfirmation(event)"><i className="fa fa-trash"></i>
                                  Delete</button>
                              </form>
                            </div>
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>



          {/* </div> */}
        </section>
      </div>
    </div>
  )
}
