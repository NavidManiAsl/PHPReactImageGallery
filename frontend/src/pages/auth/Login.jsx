import { useState } from "react";
import styled from "styled-components";

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
  display:flex;
  width: 100%;
  margin-top: 4rem;
  align-items:center;
  justify-content:center;
  
`;

const Text = styled.p`
    color:#fff;
    font-size:1rem;
    margin-right:1.5rem;
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

const Registerbutton = styled.button`
  width: 30%;
  padding: 12px;
  background-color: #444;
  color: #a77028;
  border: #a77028 1px solid;
  border-radius: 4px;
 
  cursor: pointer;
  transition: background-color 0.4s ease;

  &:hover {
    transform: scale(1.02);
  }
`;

const Login = () => {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log("Username:", username);
    console.log("Password:", password);
  };

  return (
    <Container>
      <Form onSubmit={handleSubmit}>
        <Header>Login to your account</Header>
        <Input
          type="text"
          placeholder="Username"
          value={username}
          onChange={(e) => setUsername(e.target.value)}
        />
        <Input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        <Loginbutton type="submit">Log in</Loginbutton>
        <Footer>
            <Text>Don't have an account?</Text>
            <Registerbutton type="submit">Create New</Registerbutton>
        </Footer>
      </Form>
    </Container>
  );
};

export default Login;
