import { create } from "zustand";
const useLoadingStore=create((set)=>(
    {
        hasLoaded:true,
        isLoading:false,
        changeLoadingState:()=>set((state)=>({hasLoaded:!state.hasLoaded})),
        changeIsLoadingState:()=>set((state)=>({hasLoaded:!state.isLoading}))   
    }
))
export {useLoadingStore}