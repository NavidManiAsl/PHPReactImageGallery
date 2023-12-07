import { useState } from "react";
import Home from "./pages/Home";
import Error from "./pages/Error";
import Login from "./pages/auth/Login";
import Register from './pages/auth/Register'
import "./App.css";
import { RouterProvider, createBrowserRouter } from "react-router-dom";

const router = createBrowserRouter([
  { path: "/", element: <Home />, errorElement: <Error /> },
  { path: "/login", element: <Login />, errorElement: <Error /> },
  { path: "/register", element: <Register />, errorElement: <Error /> }

]);

function App() {
  return <>
  <RouterProvider router={router}/>
  </>;
}

export default App;
