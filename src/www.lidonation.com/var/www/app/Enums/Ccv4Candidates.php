<?php

namespace App\Enums;

enum Ccv4Candidates: int
{
    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
    case FOUR = 4;
    case FIVE = 5;
    case SIX = 6;
    case SEVEN = 7;
    case EIGHT = 8;
    case NINE = 9;
    case TEN = 10;
    case ELEVEN = 11;
    case TWELVE = 12;
    case THIRTEEN = 13;
    case FOURTEEN = 14;
    case FIFTEEN = 15;
    case SIXTEEN = 16;
    case SEVENTEEN = 17;
    case EIGHTEEN = 18;
    case NINETEEN = 19;
    case TWENTY = 20;
    case TWENTY_ONE = 21;
    case TWENTY_TWO = 22;
    case TWENTY_THEE = 23;
    case TWENTY_FOUR = 24;
    case TWENTY_FIVE = 25;
    case TWENTY_SIX = 26;
    case TWENTY_SEVEN = 27;
    case TWENTY_EIGHT = 28;
    case TWENTY_NINE = 29;
    case THIRTY = 30;

    public function name(): string
    {
        return match ($this) {
            self::ONE => 'Adaku Agwunobi',
            self::TWO => 'Boaz Bandu Balume',
            self::THREE => 'Curtis Myers',
            self::FOUR => 'Daniela Balaniuc',
            self::FIVE => 'Darlington Kofa - Wleh ',
            self::SIX => 'David Baxter',
            self::SEVEN => 'George Lovegrove',
            self::EIGHT => 'HOSKY',
            self::NINE => 'Ivan Kwananda',
            self::TEN => 'Juana Attieh ',
            self::ELEVEN => 'Juliane Montag',
            self::TWELVE => 'Kevin Mohr ',
            self::THIRTEEN => 'Lee Yost ',
            self::FOURTEEN => 'Marcus Ubani ',
            self::FIFTEEN => 'Melannie Duhon',
            self::SIXTEEN => 'Mike Ndaba',
            self::SEVENTEEN => 'Mobolaji Onibudo',
            self::EIGHTEEN => 'Mohammed Mustapha Yakubu ',
            self::NINETEEN => 'Nebiyu Sultan ',
            self::TWENTY => 'Ninh Tran',
            self::TWENTY_ONE => 'Omolola Tofadeb',
            self::TWENTY_TWO => 'Özgür Yaşar Akyar',
            self::TWENTY_THEE => 'Patrick Roncato',
            self::TWENTY_FOUR => 'Patrick Tobler',
            self::TWENTY_FIVE => 'Quasar',
            self::TWENTY_SIX => 'Peter Bismarck ',
            self::TWENTY_SEVEN => 'Ross Pettitt ',
            self::TWENTY_EIGHT => 'Seán Lynch',
            self::TWENTY_NINE => 'Stevani Ongko',
            self::THIRTY => 'Thomas DiMatteo'
        };
    }

    public function profile(): string
    {
        return match ($this) {
            self::ONE => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/AdakuAgwunobi.md',
            self::TWO => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/BoazBanduBalume.md',
            self::THREE => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/CurtisMyers.md',
            self::FOUR => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/DanielaBalaniuc.md',
            self::FIVE => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/DarlingtonKofa.md',
            self::SIX => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/DavidBaxter.md',
            self::SEVEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/GeorgeLovegrove.md',
            self::EIGHT => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/HOSKY.md',
            self::NINE => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/IvanKwananda.md',
            self::TEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/JuanaAttieh.md',
            self::ELEVEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/JulianeMontag.md',
            self::TWELVE => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/KevinMohr.md',
            self::THIRTEEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/LeeYost.md',
            self::FOURTEEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/MarcusUbani.md',
            self::FIFTEEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/MelannieDuhon.md',
            self::SIXTEEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/MikeNdaba.md',
            self::SEVENTEEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/MobolajiOnibudo.md',
            self::EIGHTEEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/MohammedMustaphaYakubu.md',
            self::NINETEEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/NebiyuSultan.md',
            self::TWENTY => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/NinhTran.md',
            self::TWENTY_ONE => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/OmololaTofade.md',
            self::TWENTY_TWO => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/OzgurYasarAkyar.md',
            self::TWENTY_THEE => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/PatrickRoncato.md',
            self::TWENTY_FOUR => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/PatrickTobler.md',
            self::TWENTY_FIVE => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/Quasar.md',
            self::TWENTY_SIX => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/PeterBismarck.md',
            self::TWENTY_SEVEN => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/RossPettitt.md',
            self::TWENTY_EIGHT => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/SeanLynch.md',
            self::TWENTY_NINE => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/StevaniOngko.md',
            self::THIRTY => 'https://github.com/DripDropz/Voting/blob/main/CCv4/candidates/ThomasDiMatteo.md'
        };
    }
}
