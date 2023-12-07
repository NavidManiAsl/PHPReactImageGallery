import React from 'react';
import styled from 'styled-components';
import { Link } from 'react-router-dom';

const Container = styled.div`
  font-family: sans-serif;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #333;
  color: white;
`;

const Header = styled.h1`
  font-size: 2em;
  margin-bottom: 20px;
`;

const Subtitle = styled.p`
  font-size: 1.2em;
  margin-bottom: 40px;
`;

const LoginButton = styled(Link)`
  background-color: #a77028;
  color: white;
  padding: 10px 20px;
  margin: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  text-decoration: none;
  transition: background-color 0.4s ease;

  &:hover {
    background-color: #b68c18;
  }
`;



const Home = () => {
  return (
    <Container>
      <Header>Welcome back, Image Enthusiast!</Header>
      <Subtitle>Embark on a visual journey with Your Image Gallery.</Subtitle>

      <LoginButton to="/login">Login Now</LoginButton>

      
    </Container>
  );
};

export default Home;
