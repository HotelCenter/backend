import { Outlet, useLocation, useNavigate, useNavigation } from 'react-router-dom'
import Footer from '../layouts/Footer'
import { useEffect } from 'react'

export default function Root() {
  const nav=useNavigation()
  useEffect(()=>{
    console.log(nav)
  })
  return (

    <>
          <Outlet />
          <Footer />
    </>
  )
}
