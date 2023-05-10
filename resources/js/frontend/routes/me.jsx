import React from 'react'
import Section from '../layouts/Section'
import Cookies from 'js-cookie'
import { useLoaderData } from 'react-router-dom'
export  function Profile() {
    const user = useLoaderData(null)


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

export async function profileLoader(){
    const access_token = Cookies.get('access_token')
    let user = null
    if (access_token) {
      try {
        const { data } = await axios.post('http://127.0.0.1:8000/api/me', {}, {
          headers: {
            Authorization: `Bearer ${access_token}`
          }
        })
        user = data
      } catch (e) {
        console.log(e)
      }
  
    }
    return user
}