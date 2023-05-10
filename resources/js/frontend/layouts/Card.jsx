import React from 'react'
import { getRates } from '../utils/cards'

export default function Card({image,name,description,rating}) {
    const rateArr=getRates(rating)
  return (
<div className="card mb-3">
  <img src={`./hotels/${image}`} className="card-img-top" alt="..."/>
  <div className="card-body">
    <h5 className="card-title">{name}</h5>
    <p className="card-text">{description}</p>    
  </div>
  <div className='card-footer'>
  <div className='d-flex justify-content-between align-items-center'>
    <div>
        {rateArr.map((cls,i)=><i className={`bi ${cls}`} style={{color:"var(--secondary-color)"}} key={i}></i>)}

    </div>
    </div>
    <a className='btn btn-outline-success w-100 my-2 text-dark fw-bold'>Check availability</a>
  </div>
</div>
    )
}
