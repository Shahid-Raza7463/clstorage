import React from 'react';
import { Link } from 'react-router-dom';

function Sidebar() {
  return (
    <ul className="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li className="nav-item">
        <a href="#" className="nav-link">
          <i className="nav-icon fas fa-chart-pie"></i>
          <p>
            Charts
            <i className="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul className="nav nav-treeview">
          <li className="nav-item">
            <Link to="/pages/charts/chartjs" className="nav-link">
              <i className="far fa-circle nav-icon"></i>
              <p>ChartJS</p>
            </Link>
          </li>
          <li className="nav-item">
            <Link to="/pages/charts/flot" className="nav-link">
              <i className="far fa-circle nav-icon"></i>
              <p>Flot</p>
            </Link>
          </li>
          <li className="nav-item">
            <Link to="/pages/charts/inline" className="nav-link">
              <i className="far fa-circle nav-icon"></i>
              <p>Inline</p>
            </Link>
          </li>
          <li className="nav-item">
            <Link to="/pages/charts/uplot" className="nav-link">
              <i className="far fa-circle nav-icon"></i>
              <p>uPlot</p>
            </Link>
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
            <Link to="/pages/UI/general" className="nav-link">
              <i className="far fa-circle nav-icon"></i>
              <p>General</p>
            </Link>
          </li>
          <li className="nav-item">
            <Link to="/pages/UI/icons" className="nav-link">
              <i className="far fa-circle nav-icon"></i>
              <p>Icons</p>
            </Link>
          </li>
          <li className="nav-item">
            <Link to="/pages/UI/buttons" className="nav-link">
              <i className="far fa-circle nav-icon"></i>
              <p>Buttons</p>
            </Link>
          </li>
          {/* Add more UI elements here */}
        </ul>
      </li>
    </ul>
  );
}

export default Sidebar;
