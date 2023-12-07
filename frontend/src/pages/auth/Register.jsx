import { useState } from "react";
import styled from "styled-components";
import {
  validateEmail,
  validatePassword,
  validateUsername,
} from "../../utils/validationUtils";
import { useAuth } from "../../auth/authContext";

const Container = styled.div`
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #333;
  overflow: hidden;
`;

const Form = styled.form`
  display: flex;
  flex-direction: column;
  width: 340px;
  padding: 20px;
  border: 1px solid #555;
  border-radius: 8px;
  background-color: #444;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
`;

const Header = styled.h1`
  text-align: center;
  margin-bottom: 1.2rem;
  font-size: 1.5rem;
  font-family: sans-serif;
  color: #fff;
`;

const Footer = styled.p`
  font-family: sans-serif;
  display: flex;
  width: 100%;
  margin-top: 4rem;
  color: #fff;
  align-items: center;
  justify-content: center;
  font-weight: light;
`;

const Input = styled.input`
  width: calc(100% - 24px);
  padding: 12px;
  margin-bottom: 1.2rem;
  border: 1px solid #666;
  border-radius: 4px;
  outline: none;
  background-color: #555;
  color: #fff;
`;

const Registerbutton = styled.button`
  width: 100%;
  padding: 12px;
  background-color: #a77028;
  color: #fff;
  border: none;
  border-radius: 4px;
  margin-bottom: 1.2rem;
  cursor: pointer;
  transition: background-color 0.4s ease;

  &:hover {
    background-color: #b68c18;
  }
`;
const style = {
  anchorTag: {
    color: "inherit",
    textDecoration: "none",
  },
  alert: {
    color: "red",
    margin: "3px",
  },
};

const Loginbutton = styled.button`
  width: 30%;
  padding: 12px;
  background-color: #444;
  color: #a77028;
  border: #a77028 1px solid;
  border-radius: 4px;
  margin-left: 1.5rem;

  cursor: pointer;
  transition: background-color 0.4s ease;

  &:hover {
    transform: scale(1.02);
    color: #b68c18;
    border: #b68c18 1px solid;
  }
`;

const Register = () => {
  const { handleLogin, isAuthenticated, user } = useAuth();

  const [formData, setFormData] = useState({
    email: "",
    username: "",
    password: "",
    passwordConfirm: "",
  });

  const [formError, setFormError] = useState({
    username: "",
    email: "",
    password: "",
    passwordConfirm: "",
  });

  const validateFormData = (username, email, password, passwordConfirm) => {
    const { status: validUsername, message: usernameError } =
      validateUsername(username);
    if (!validUsername) {
      setFormError({ ...formError, username: usernameError });
    }

    const { status: validEmail, message: emailError } = validateEmail(email);
    if (!validEmail) {
      setFormError({
        ...formError,
        email: emailError,
      });
    }

    const {
      belongsTo: belongsTo,
      status: validPassword,
      message: passwordError,
    } = validatePassword(password, passwordConfirm);
    
    if (!validPassword) {
     setFormData({...formError, [belongsTo]:passwordError})
    }
  };

  const handleInput = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handelSubmit = () => {};

  //TODO must hash the password (must be synced with laravel).
  return (
    <Container>
      <Form onSubmit={handelSubmit}>
        <Header>Register Now!</Header>
        <p style={style.alert}>
          {formError.email ? "\u2022" + formError.email : ""}
        </p>
        <Input
          type="text"
          placeholder="Choose a Username"
          value={formData.username}
          onChange={handleInput}
          name="username"
        />
        <Input
          type="text"
          placeholder="Enter your email"
          value={formData.email}
          onChange={handleInput}
          name="email"
        />
        <p style={style.alert}>
          {formError.password ? "\u2022" + formError.password : ""}
        </p>
        <Input
          type="password"
          placeholder="Choose a Password"
          value={formData.password}
          onChange={handleInput}
          autoComplete="off"
          name="password"
        />
        <Input
          type="password"
          placeholder="Retype password"
          value={formData.passwordConfirm}
          onChange={handleInput}
          autoComplete="off"
          name="passwordConfirm"
        />
        <p style={style.alert}>
          {formError.authentication ? "\u2022" + formError.authentication : ""}
        </p>
        <Registerbutton type="submit">Register</Registerbutton>
        <Footer>
          Already have an account?
          <Loginbutton type="submit">
            <a href="login" style={style.anchorTag}>
              Login
            </a>
          </Loginbutton>
        </Footer>
      </Form>
    </Container>
  );
};

export default Register;
