import { createContext } from "react";

const LoadingContext=createContext(undefined)
const HasLanguageChangedContext=createContext({hasLanguageChanged:false,setHasLanguageChanged:()=>{}})
export {LoadingContext,HasLanguageChangedContext}