import Splide, { ComponentConstructor } from '@splidejs/splide';
import { SplideShaderCarouselOptions as Options } from '../types';
/**
 * The frontend class for a Splide carousel with shader transition.
 *
 * @since 0.0.1
 */
export declare class SplideShaderCarousel extends Splide {
    /**
     * Checks if WebGL is supported or not.
     *
     * @return `true` if webGL is available, or otherwise `false`.
     */
    static isAvailable(): boolean;
    /**
     * Keeps the fragment shader.
     */
    readonly fragmentShader: string;
    /**
     * The SplideShaderTransition constructor.
     *
     * @param target         - The selector for the target element, or the element itself.
     * @param fragmentShader - The fragment shader.
     * @param options        - Optional. An object with options.
     */
    constructor(target: string | HTMLElement, fragmentShader: string, options?: Options);
    /**
     * Initializes the instance.
     *
     * @param Extensions - Optional. An object with extensions.
     */
    mount(Extensions?: Record<string, ComponentConstructor>): this;
    /**
     * Asynchronously mounts the component.
     * The returned promise will be resolved when all textures are loaded and the shader gets ready to render the scene.
     *
     * @param Extensions - Optional. An object with extensions.
     *
     * @return A promise when the shader gets ready.
     */
    mountAsync(Extensions?: Record<string, ComponentConstructor>): Promise<void>;
}
//# sourceMappingURL=SplideShaderCarousel.d.ts.map