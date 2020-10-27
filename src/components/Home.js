import React from "react";
import Jumbotron from "react-bootstrap/Jumbotron";
const Home = (props) => {
  return (
    <Jumbotron>
      <h1 className="display-4">Welcome to Nanno's Foods!</h1>
      <p className="lead">
        Nanno's Foods is a family owned grocery store with an abundant selection
        of foods and other products.
      </p>
      <hr className="my-4" />
      <p> Click the button below to learn more about our store </p>
      <p className="lead">
        <a className="btn btn-primary btn-lg" href="/" role="button">
          Learn more
        </a>
      </p>
    </Jumbotron>
  );
};

export default Home;
