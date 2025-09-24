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


            {/* <ul className="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li className="nav-item">
                  <a href="pages/gallery.html" className="nav-link">
                    <i className="nav-icon far fa-image"></i>
                    <p>
                      Gallery
                    </p>
                  </a>
                </li>
              </ul> */}



            {/* <ul className="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> */}
            {/* <!-- Add icons to the links using the .nav-icon className
               with font-awesome or any other icon font library --> */}



            {/* <li className="nav-item menu-open">
                  <a href="#" className="nav-link active">
                    <i className="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Dashboard
                      <i className="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul className="nav nav-treeview">
                    <li className="nav-item">
                      <a href="./index1.html" className="nav-link active">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Dashboard v1</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="./index2.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Dashboard v2</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="./index3.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Dashboard v3</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li className="nav-item">
                  <a href="pages/widgets.html" className="nav-link">
                    <i className="nav-icon fas fa-th"></i>
                    <p>
                      Widgets
                      <span className="right badge badge-danger">New</span>
                    </p>
                  </a>
                </li>
                <li className="nav-item">
                  <a href="#" className="nav-link">
                    <i className="nav-icon fas fa-copy"></i>
                    <p>
                      Layout Options
                      <i className="fas fa-angle-left right"></i>
                      <span className="badge badge-info right">6</span>
                    </p>
                  </a>
                  <ul className="nav nav-treeview">
                    <li className="nav-item">
                      <a href="pages/layout/top-nav.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Top Navigation</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/layout/top-nav-sidebar.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Top Navigation + Sidebar</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/layout/boxed.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Boxed</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/layout/fixed-sidebar.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Fixed Sidebar</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/layout/fixed-sidebar-custom.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Fixed Sidebar <small>+ Custom Area</small></p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/layout/fixed-topnav.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Fixed Navbar</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/layout/fixed-footer.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Fixed Footer</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/layout/collapsed-sidebar.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Collapsed Sidebar</p>
                      </a>
                    </li>
                  </ul>
                </li> */}


            {/* <li className="nav-item">
                  <a href="#" className="nav-link">
                    <i className="nav-icon fas fa-chart-pie"></i>
                    <p>
                      Charts
                      <i className="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul className="nav nav-treeview">
                    <li className="nav-item">
                      <a href="pages/charts/chartjs.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>ChartJS</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/charts/flot.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Flot</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/charts/inline.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Inline</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/charts/uplot.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>uPlot</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li className="nav-item">
                  <a href="#" className="nav-link">
                    <i className="nav-icon fas fa-tree"></i>
                    <p>
                      UI Elements
                      <i className="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul className="nav nav-treeview">
                    <li className="nav-item">
                      <a href="pages/UI/general.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>General</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/UI/icons.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Icons</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/UI/buttons.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Buttons</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/UI/sliders.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Sliders</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/UI/modals.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Modals & Alerts</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/UI/navbar.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Navbar & Tabs</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/UI/timeline.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Timeline</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/UI/ribbons.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Ribbons</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li className="nav-item">
                  <a href="#" className="nav-link">
                    <i className="nav-icon fas fa-edit"></i>
                    <p>
                      Forms
                      <i className="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul className="nav nav-treeview">
                    <li className="nav-item">
                      <a href="pages/forms/general.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>General Elements</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/forms/advanced.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Advanced Elements</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/forms/editors.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Editors</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/forms/validation.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Validation</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li className="nav-item">
                  <a href="#" className="nav-link">
                    <i className="nav-icon fas fa-table"></i>
                    <p>
                      Tables
                      <i className="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul className="nav nav-treeview">
                    <li className="nav-item">
                      <a href="pages/tables/simple.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>Simple Tables</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/tables/data.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>DataTables</p>
                      </a>
                    </li>
                    <li className="nav-item">
                      <a href="pages/tables/jsgrid.html" className="nav-link">
                        <i className="far fa-circle nav-icon"></i>
                        <p>jsGrid</p>
                      </a>
                    </li>
                  </ul>
                </li> */}




            {/* <li className="nav-header">EXAMPLES</li>
                <li className="nav-item">
                  <a href="pages/calendar.html" className="nav-link">
                    <i className="nav-icon far fa-calendar-alt"></i>
                    <p>
                      Calendar
                      <span className="badge badge-info right">2</span>
                    </p>
                  </a>
                </li>
                <li className="nav-item">
                  <a href="pages/gallery.html" className="nav-link">
                    <i className="nav-icon far fa-image"></i>
                    <p>
                      Gallery
                    </p>
                  </a>
                </li>
                <li className="nav-item">
                  <a href="pages/kanban.html" className="nav-link">
                    <i className="nav-icon fas fa-columns"></i>
                    <p>
                      Kanban Board
                    </p>
                  </a>
                </li>
                <li className="nav-item">
                  <a href="https://adminlte.io/docs/3.1/" className="nav-link">
                    <i className="nav-icon fas fa-file"></i>
                    <p>Documentation</p>
                  </a>
                </li> */}
            {/* </ul> */}
          </nav>
        </div>
      </aside>

      {/* Content goes to hare */}
      <div className="content-wrapper">
        <section className="content">
          {/* <div className="container-fluid"> */}
          <div class="container mt-3">
            <div className="card card-default">
              <div class="card-header">
                <h1 className="card-title" style={{ fontSize: '23px' }}>Users Management</h1>
                <div className="card-tools">
                  <a href="" className="btn btn-sm btn-success">
                    <i className="fa fa-plus"></i> Add
                  </a>
                </div>
              </div>

              <div class="card-body">
                <table className="table table-bordered" style={{ marginLeft: '20px' }}>
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
            </div>
          </div>
          {/* </div> */}
        </section>
      </div>
    </div>
  )
}
