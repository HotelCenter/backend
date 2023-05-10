import './style/common.css'
import { createBrowserRouter, RouterProvider } from 'react-router-dom';
import Home, { hotelsLoader } from './routes/Home';
import Root from './routes/Root';
import About from './routes/About';
import Aide from './routes/Aide';
import LogIn from './routes/LogIn';
import SignUp from './routes/SignUp';
import React, { lazy } from 'react';
import { Profile, profileLoader } from './routes/me';

const router = createBrowserRouter(
  [
  {
    path: '/',
    element: <Root />,
    children: [
      {
        element: <Home />,
        index:true,
        loader:hotelsLoader,
        path:'/'
      },
      {

        path: '/about',
        element: <About />
      },
      {

        path: '/me',
        loader:profileLoader,
        element:<Profile/>
      },
      {

        path: '/aide',
        element: <Aide />
      },
      {

        path: '/login',
        element: <LogIn />
      },
      {

        path: '/signup',
        element: <SignUp />
      },

    ]
  },

])

function App() {
  return (
    <RouterProvider fallbackElement={<h1>...Loading</h1>} router={router} />
  );
}

export default App;
