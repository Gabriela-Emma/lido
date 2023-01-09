import { EventInterfaceObject, RequestIntervalInterface } from '@splidejs/splide';
import { Renderer } from './Renderer';
import { Material } from './Material';
import { ShaderCarouselOptions, TextureSource } from '../types';
/**
 * The class for building a carousel with using the GLSL shader for transition.
 *
 * @since 0.0.1
 */
export declare class ShaderCarousel {
    /**
     * The canvas element to render the carousel to.
     */
    readonly canvas: HTMLCanvasElement;
    /**
     * A Renderer instance.
     */
    readonly renderer: Renderer;
    /**
     * A custom material instance.
     */
    readonly material: Material;
    /**
     * An EventInterfaceObject instance.
     */
    protected readonly event: EventInterfaceObject;
    /**
     * Holds options.
     */
    protected readonly options: ShaderCarouselOptions;
    /**
     * The active RequestInterval instance.
     */
    protected interval: RequestIntervalInterface | undefined;
    /**
     * The ShaderCarousel constructor.
     *
     * @param canvas         - A canvas element to render the carousel.
     * @param fragmentShader - A fragment shader.
     * @param options        - Optional. An object with options.
     */
    constructor(canvas: HTMLCanvasElement, fragmentShader: string, options?: ShaderCarouselOptions);
    /**
     * Mounts the carousel.
     *
     * @param sources - Optional. An array with texture sources.
     * @param onReady - Optional. Called when all image are loaded.
     */
    mount(sources?: TextureSource[], onReady?: () => void): void;
    /**
     * Asynchronously mounts the carousel.
     *
     * @param sources - Optional. An array with texture sources.
     *
     * @return A promise resolved when all images are loaded.
     */
    mountAsync(sources?: TextureSource[]): Promise<void>;
    /**
     * Destroys the instance.
     */
    destroy(): void;
    /**
     * Goes to the specified index.
     *
     * @param index   - An index to go.
     * @param reverse - Optional. Explicitly sets the transition direction.
     */
    go(index: number, reverse?: boolean): void;
    /**
     * Resizes the slider to fit the content to the parent element.
     */
    resize(): void;
    /**
     * Manually sets the progress.
     *
     * @internal
     *
     * @param progress - Progress rate to set from 0 to 1.
     */
    setProgress(progress: number): void;
    /**
     * Returns the current width.
     *
     * @return The current width. If the parent of the canvas is not available, this always returns 0.
     */
    getWidth(): number;
    /**
     * Returns the current height.
     *
     * @return The current height. If the parent of the canvas is not available, this always returns 0.
     */
    getHeight(): number;
    /**
     * Returns the number of textures.
     */
    getLength(): number;
    /**
     * Manually decodes textures beforehand.
     */
    protected decode(): void;
    /**
     * Manually decodes textures around the current texture.
     */
    protected decodeAround(): void;
    /**
     * Renders the scene to the canvas.
     */
    protected render(): void;
    /**
     * Listens to some events.
     * Needs to resize the canvas and the scene when the window is resized.
     */
    protected listen(): void;
    /**
     * Changes the carousel forwards or backwards.
     *
     * @param reverse - Determines whether to go to the prev slide or the next one.
     */
    protected transition(reverse: boolean): void;
    /**
     * Called every time when the progress rate changes.
     * Do not forget to call the render method to update the shader.
     *
     * @param reverse  - `true` will be passed for backwards transition.
     * @param progress - Progress rate.
     */
    protected onProgress(reverse: boolean, progress: number): void;
    /**
     * Called when transition ends.
     */
    protected onTransitionEnd(): void;
}
//# sourceMappingURL=ShaderCarousel.d.ts.map