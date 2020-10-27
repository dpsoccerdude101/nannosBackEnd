import React, { useState } from "react";
import axios from "axios";
import { getAllRequiredInputs, postData } from "../functions/functions";
const EmployeeLogin = (props) => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");

  /**
   *
   * @param {Event} e
   */
  const submitForm = (e) => {
    e.preventDefault();
    console.dir(e.target.querySelectorAll("input"));
    const requiredInputs = getAllRequiredInputs(e);
    let obj = {};
    for (const input of requiredInputs) {
      input.reportValidity();
      obj = { ...obj, [input.name]: input.value };
    }
    console.dir(obj);
    axios({
      method: "post", //you can set what request you want to be
      url: "http://localhost/phpFunctions/empLogin.php",
      data: obj ,
      headers: {
        "Content-Type": "application/json",
        "Access-Control-Allow-Origin": "*",
        "Access-Control-Allow-Credentials": true,
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
      mode: "no-cors",
    })
      .then((res) => console.log(res.data))
      .catch((error) => console.log(error));
    //console.dir(response);
  };
  return (
    <>
      <form onSubmit={(e) => submitForm(e)}>
        <div className="container">
          <label htmlFor="username">
            <b>Username</b>
          </label>
          <input
            type="text"
            placeholder="Enter Username"
            name="uname"
            value={username}
            onChange={(e) => setUsername(e.target.value)}
            required
          />
          <label htmlFor="psw">
            <b>Password</b>
          </label>
          <input
            type="password"
            placeholder="Enter Password"
            name="psw"
            required
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <button type="submit">Login</button>
        </div>
      </form>
    </>
  );
};
export default EmployeeLogin;
