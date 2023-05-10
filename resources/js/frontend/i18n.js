import i18next from "i18next";
import { initReactI18next } from "react-i18next";
i18next.use(initReactI18next).init({
    lang: 'en',
    fallbackLng: 'en',
    interpolation: {
        escapeValue: false
    },
    resources: {
        'en': {
            translation: {
                home: {
                    title: "You're Welcome -HotelStar"
                },
                about:{
                    title:"About us"
                }
            }
        },
        'fr': {
            translation: {
                home: {
                    title: "Vous êtes les bienvenus -HotelStar"
                },
                about: {
                    title: "À propos de nous"
                }
            }
        },
        'ar': {
            translation: {
                home:{
                title: "مرحبًا بك -HotelStar"
                },
                about:{
                    title:"معلومات عنا"
                }
            }
        },
    }
});
export default i18next;