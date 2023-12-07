import styled from "styled-components";
import { useRouteError, Link } from "react-router-dom";

const Container = styled.div`
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #333;
  overflow: hidden;
`;

const StyledError = styled.div`
  text-align: center;
  padding: 40px;
  border: 2px solid #a77028; 
  border-radius: 12px;
  background-color: #444;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
`;

const Header = styled.h1`
  font-size: 2rem; 
  font-family: sans-serif;
  color: #a77028; 
  margin-bottom: 1.5rem;
`;

const Text = styled.p`
  color: #fff;
  font-size: 1.2rem; 
  font-family: sans-serif;
`;

const Message = styled.p`
  color: #fff;
  font-size: 1.2rem; 
  font-family: sans-serif;
  margin-bottom: 1.5rem;
`;


const style = {
  returnLink:{
    color:'#a77028'
  }
}

const Error = () => {
  const error = useRouteError();
  console.error(error);
  return (
    <Container>
      <StyledError>
        <Header>Oops!</Header>
        <Text>An unexpected error has occurred.</Text>
        <Message>{error.statusText || error.message}</Message>
       <Link to={'/'} style={style.returnLink}>Return to Main Page</Link>
      </StyledError>
    </Container>
  );
};

export default Error;
