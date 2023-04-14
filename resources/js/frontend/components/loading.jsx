import '../style/loading.css'
export default function Loading() {
    return <div className="loader">
        <div className='lds-grid'>
            <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
        </div>
    </div>
}