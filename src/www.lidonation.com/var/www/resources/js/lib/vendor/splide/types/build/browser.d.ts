import * as shaders from '../shaders';
import { SplideShaderCarousel as Core } from '../';
/**
 * Lets the compiler know the global variable.
 */
declare global {
    interface Window {
        SplideShaderCarousel: typeof SplideShaderCarousel;
    }
}
/**
 * Provides some data as static variables
 *
 * @since 0.0.1
 */
declare class SplideShaderCarousel extends Core {
    /**
     * Stores all shaders.
     */
    static shaders: typeof shaders;
}
export {};
//# sourceMappingURL=browser.d.ts.map