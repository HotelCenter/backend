import i18next from "i18next";
import { useEffect } from "react";
import { useTranslation } from "react-i18next";

function usePageTitle(page){
    const {t}=useTranslation('translation',{keyPrefix:page})
    useEffect(()=>{
        console.log('js')
        document.title=t('title')
    })

}
export {usePageTitle}