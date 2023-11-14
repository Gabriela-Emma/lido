import './bootstrap';
import '../scss/partners.scss';
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import lidoPartners from '@/global/utils/lidoPartners';
import cardanoWallet from '@/global/utils/lidoPartners';



Alpine.data('lidoPartners', lidoPartners.bind(Alpine));
Alpine.data('cardanoWallet', cardanoWallet.bind(Alpine));

Livewire.start();
