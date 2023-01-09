import { Options } from '@splidejs/splide';
import { MaterialParameters, TextureSource } from './material';
/**
 * The interface for options of the ShaderCarousel class.
 *
 * @since 0.0.1
 */
export interface ShaderCarouselOptions {
    /**
     * The transition speed in milliseconds.
     */
    speed?: number;
    /**
     * An array with texture sources.
     */
    sources?: TextureSource[];
    /**
     * The mask URL.
     */
    mask?: string;
    /**
     * Changes the easing function.
     */
    easingFunc?: (t: number) => number;
    /**
     * Changes the default vertex shader.
     */
    vertexShader?: string;
    /**
     * Parameters for the fragment shader.
     */
    material?: MaterialParameters;
    /**
     * Configures the timing when the browser decodes textures:
     *
     * - `'load'`: Decodes textures on load phase. Makes loading time longer, but ensures all images are ready
     * - `'nearby'`: Asynchronously decodes textures around the current slide (default)
     */
    preDecoding?: false | 'load' | 'nearby';
}
/**
 * The interface for options.
 *
 * @since 0.0.1
 */
export interface SplideShaderCarouselOptions extends ShaderCarouselOptions, Options {
    /**
     * Determines whether to keep `alt` attributes of images used for textures, converting them into screen reader texts.
     */
    keepAlt?: boolean;
    /**
     * Suppresses the reverse transition on rewind (At least 3 images are required).
     */
    continuous?: boolean;
    /**
     * Determines whether to wait for initialization of the ShaderCarousel.
     * If `true`, the carousel will be hidden until then.
     */
    awaitInit?: boolean;
}
//# sourceMappingURL=options.d.ts.map