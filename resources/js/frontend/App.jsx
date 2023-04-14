import './style/common.css'
import axios from 'axios'
import { createBrowserRouter, RouterProvider } from 'react-router-dom';
import Home from './routes/Home';
import Root from './routes/Root';
import About from './routes/About';
import Aide from './routes/Aide';
import LogIn from './routes/LogIn';
import SignUp from './routes/SignUp';
import { useEffect } from 'react';
import Cookies from 'js-cookie';
import Profile from './routes/Profile';
const router = createBrowserRouter([
  {
    path: '/',
    element: <Root />,
    children: [
      {
        path: '/',
        element: <Home />,
      },
      {

        path: '/about',
        element: <About />
      },
      {

        path: '/profile',
        element: <Profile />
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
    <RouterProvider router={router} />
  );
}

export default App;
