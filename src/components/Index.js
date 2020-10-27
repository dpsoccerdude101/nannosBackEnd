import React, { useState, useEffect } from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import Home from "./Home";
import EmployeeLogin from "./EmployeeLogin";
import VendorLogin from "./VendorLogin";
import SelectMenu from "./SelectMenu";
const Index = (props) => {
  return (
    <Router>
      {/* Nav Bar Creation */}
      <Navbar className="navbar navbar-expand-lg navbar-light bg-light">
        <Navbar.Brand>
          <Link to="/">Nanno's Foods</Link>
        </Navbar.Brand>
        <Navbar.Toggle />
        <Navbar.Collapse>
          <Nav className="mr-auto" as="ul">
            <Nav.Item as="li">
              <Link to="/employeeLogin" className="nav-link">
                Nanno's Representative Login
              </Link>
            </Nav.Item>
            <Nav.Item as="li">
              <Link to="/vendorLogin" className="nav-link">
                Vendor Login
              </Link>
            </Nav.Item>
            <Nav.Item as="li">
              <Link to="/" className="nav-link">
                About Us
              </Link>
            </Nav.Item>
          </Nav>
          <Navbar.Text as="span">
            Bringing Food to You With Nanno's Foods
          </Navbar.Text>
        </Navbar.Collapse>
      </Navbar>

      <SelectMenu />
      <br />
      <br />
      <br />
      <br />

      <Switch>
        <Route path="/employeeLogin">
          <EmployeeLogin />
        </Route>
        <Route path="/vendorLogin">
          <VendorLogin />
        </Route>
        <Route path="/">
          <Home />
        </Route>
      </Switch>
    </Router>
  );
};

export default Index;
