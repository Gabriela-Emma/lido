import lucidInstance from "./lucidInstance.js";


async function getEpoch(date) {
    const unixTime = new Date(date).getTime();
    const lucid = await lucidInstance();
    const floor = Math.floor;
    let slot_number =  lucid.utils.unixTimeToSlot(unixTime);

    return floor(slot_number / 432000);
}

export {getEpoch}