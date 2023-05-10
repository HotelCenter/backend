import React, { useEffect } from 'react'
import Header from '../layouts/Header'
import Navbar  from '../components/home/Navbar'
import Carousel from '../components/carousel'
import SearchPanel from '../components/searchPanel'
import Section from '../layouts/Section'
import Card from '../layouts/Card'
import Cards from '../components/home/cards'
import HotelCanvas from '../layouts/HotelCanvas'
import { useTranslation } from 'react-i18next'
import { usePageTitle } from '../hooks'
import i18next from 'i18next'
import axios from 'axios'
import { useLoaderData } from 'react-router-dom'

export default function Home() {
  const hotels=useLoaderData()

  usePageTitle('home')
  
  return (
    <>
    <Header Navbar={Navbar}/>
    <HotelCanvas/>

    <Section>

      <Cards>
      {hotels.map((hotel,i)=><Card key={i} {...hotel}/>)}
      </Cards>
    </Section>
    </>
  )
}

export async function hotelsLoader(){
  let hotels=[]
  try{
    const {data}=await axios.get('http://127.0.0.1:8000/api/hotels')
    console.log(data)
    hotels=data
  }catch(e){
    console.error(e)
  }
  return hotels
}