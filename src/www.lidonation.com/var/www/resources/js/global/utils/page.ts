import { usePage } from "@inertiajs/vue3"
import ziggy from "../models/ziggy"

const Page = usePage<{
    ziggy: ziggy
}>()

export default Page