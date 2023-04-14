import { Outlet, useLocation } from 'react-router-dom'
import Footer from '../layouts/Footer'
import Loading from '../components/loading'
import { useEffect, useState } from 'react'
import { LoadingContext } from '../context/loading'

export default function Root() {
  const location = useLocation()
  const [isLoading, setIsLoading] = useState(true)
  const [isLoaded, setIsLoaded] = useState(false)
  useEffect(() => {
    if (location.pathname !== '/profile') {
      setIsLoaded(true)
    }
  }, [])
  return (
    <>

      <LoadingContext.Provider value={{
        setIsLoading: (v) => {
          setIsLoading(v)
        },
        setIsLoaded: (v) => {
          setIsLoaded(v)
        },
        isLoading,
        isLoaded
      }}>
        {!isLoaded && <Loading />}

        {isLoading &&
          <>
            <Outlet />
            <Footer />
          </>}
      </LoadingContext.Provider>
    </>
  )
}
