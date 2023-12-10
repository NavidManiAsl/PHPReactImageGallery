import { useState } from "react";
import styled from "styled-components";
import { validateEmail, validatePassword } from "../../utils/validationUtils";
import { useAuth } from "../../auth/authContext";
import {useNavigate} from 'react-router-dom'

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
  font-weight:light;
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

const Loginbutton = styled.button`
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

const Registerbutton = styled.button`
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

const Login = () => {
  const { handleLogin, isAuthenticated, user } = useAuth();
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });

  const [formError, setFormError] = useState({
    email: "",
    password: "",
    authentication: "",
  });

  const handleEmail = (e) => {
    setFormData({ ...formData, email: e.target.value });
  };

  const handlePassword = (e) => {
    setFormData({ ...formData, password: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setFormError({
      email: "",
      password: "",
      authentication: "",
    });
    const validatedEmail = validateEmail(formData.email);
    if (!validatedEmail.status) {
      setFormError((prevState) => ({
        ...prevState,
        email: validatedEmail.message,
      }));
    }

    const validatedPassword = validatePassword(formData.password);
    if (!validatedPassword.status) {
      setFormError((prevState) => ({
        ...prevState,
        password: validatedPassword.message,
      }));
    }

    !formError.email &&
      !formError.password &&
      (await handleLogin(formData));
    isAuthenticated && navigate('/main')
      
  };
  //TODO must hash the password (must be synced with laravel).
  return (
    <Container>
      <Form onSubmit={handleSubmit}>
        <Header>Login to your account</Header>
        <p style={style.alert}>
          {formError.email ? "\u2022" + formError.email : ""}
        </p>
        <Input
          type="text"
          placeholder="email"
          value={formData.email}
          onChange={handleEmail}
          autoComplete="off"
        />
        <p style={style.alert}>
          {formError.password ? "\u2022" + formError.password : ""}
        </p>
        <Input
          type="password"
          placeholder="Password"
          value={formData.password}
          onChange={handlePassword}
          autoComplete="off"
        />
        <p style={style.alert}>
          {formError.authentication ? "\u2022" + formError.authentication : ""}
        </p>
        <Loginbutton type="submit">Log in</Loginbutton>
        <Footer>
          Don't have an account?
          <Registerbutton type="submit">
            <a href="register" style={style.anchorTag}>
              Create New
            </a>
          </Registerbutton>
        </Footer>
      </Form>
    </Container>
  );
};

export default Login;
