import React, { useContext, useEffect, useState } from 'react'
import Header from '../layouts/Header'
import Section from '../layouts/Section'
import Cookies from 'js-cookie'
import { LoadingContext } from '../context/loading'
export default function Profile() {
    const {  setIsLoading,setIsLoaded } = useContext(LoadingContext)
    const [user, setUser] = useState(null)

    useEffect(() => {
        const access_token = Cookies.get('access_token')
        if (access_token) {
            (async () => {
                try {
                    setIsLoading(true)
                    setIsLoaded(false)

                    const { data } = await axios.post('http://127.0.0.1:8000/api/me', {}, {
                        headers: {
                            Authorization: `Bearer ${access_token}`
                        }
                    })
                    setUser(data)
                } catch (e) {
                    console.log(e)
                } finally {
                    setIsLoading(true)
                    setIsLoaded(true)
                }

            })()

        }

    }, [])


    return (
        <>

            <Section>
                {user &&
                    <h1>{user.name}</h1>
                }
            </Section>
        </>
    )
}
