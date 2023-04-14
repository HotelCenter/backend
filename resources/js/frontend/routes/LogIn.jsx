import React from 'react'
import Header from '../layouts/Header'
import Navbar  from '../components/home/Navbar'
import Section from '../layouts/Section'
import { NavLink, useNavigate } from 'react-router-dom'
import Cookies from 'js-cookie'
export default function LogIn() {
  const navigate=useNavigate()
  const SubmitHandler=(e)=>{
    const {target:form}=e
    const {email,password}=form
    e.preventDefault()
    axios.post('http://127.0.0.1:8000/api/login',{
        email:email.value,
        password:password.value
    }).then((res)=>{
      const {data}=res
      Cookies.set('access_token',data.access_token,{expires:data.expires_in})
      navigate('/profile')
    })
  }
  return (
    <>
    <Header Navbar={Navbar}/>

    <Section>
        
        <form  onSubmit={SubmitHandler} className='row'>

            <div className='col-6' style={{margin:"25vh auto",padding:"1.2rem",boxShadow:"0 0 6px 2px #eeeeee, 0 0 5px 1px #0171c345"}}>
                    <div className="form-floating w-100 mb-2">
                        <input type="text" className="form-control " id="floatingInputGroup1" placeholder="Email" name='email'/>
                        <label htmlFor="floatingInputGroup1">Email</label>
                    </div>
                    <div className="form-floating w-100 mb-2">
                        <input type="text" className="form-control " id="floatingInputGroup1" placeholder="Password" name='password'/>
                        <label htmlFor="floatingInputGroup1">Password</label>
                    </div>
                    
                    <button type="submit" className='btn btn-outline-primary '>Log In</button>
                    <NavLink to={'/signup'} className="btn btn-outline-warning mx-2">Sign Up</NavLink>
                    </div>
                    </form>
    </Section>
    </>
  )
}
