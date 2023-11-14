import User from "@/global/models/user"

export default interface ziggy {
    url: string
    base_url:string
    user:User
    asset_url:string
    locale: string
    routes: {}
}