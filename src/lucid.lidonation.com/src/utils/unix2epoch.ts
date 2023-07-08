import lucidInstance from "./lucidInsatnce.js";


async function getEpoch(date:string) {
    const unixTime = new Date(date).getTime();
    const lucid = await lucidInstance();
    const floor = Math.floor;
    let slot_number = (await lucid).utils.unixTimeToSlot(unixTime);

    return floor(slot_number / 432000);
}

export {getEpoch}