import { ShaderMaterial, Vector2, VideoTexture } from 'three';
import { IUniform } from 'three/src/renderers/shaders/UniformsLib';
import { Texture } from 'three/src/textures/Texture';
import { MaterialParameters, TextureSource } from '../types';
/**
 * The class for handling the shader and changing textures.
 *
 * @since 0.0.1
 */
export declare class Material {
    /**
     * The ShaderMaterial instance.
     */
    readonly material: ShaderMaterial;
    /**
     * Stores Texture instances.
     */
    readonly textures: Array<{
        texture: Texture;
        ratio: Vector2;
    }>;
    /**
     * An object with uniforms for the shader.
     */
    protected readonly uniforms: {
        [uniform: string]: IUniform;
    };
    /**
     * Stores provided sources.
     */
    protected sources: TextureSource[];
    /**
     * A mask URL.
     */
    protected mask: string | undefined;
    /**
     * The current texture index.
     */
    protected index: number;
    /**
     * The next texture index.
     */
    protected nextIndex: number;
    /**
     * The Material constructor.
     *
     * @param vertexShader   - A vertex shader.
     * @param fragmentShader - A fragment shader.
     * @param sources        - Optional. An array with image URLs.
     * @param mask           - Optional. A mask URL.
     */
    constructor(vertexShader: string, fragmentShader: string, sources?: TextureSource[], mask?: string);
    /**
     * Destroys the instance.
     */
    destroy(): void;
    /**
     * Adds image URLs.
     * This muse be called before `load()`.
     *
     * @param sources - An array with texture sources.
     */
    add(sources: TextureSource[]): void;
    /**
     * Starts loading textures.
     *
     * @return A promise that is resolved with Texture instances when all images get ready.
     */
    load(): Promise<Texture[]>;
    /**
     * Updates the dimension used in the shader.
     *
     * @param width  - The carousel width.
     * @param height - The carousel height.
     */
    setSize(width: number, height: number): void;
    /**
     * Sets a new index and updates textures in the shader.
     *
     * @param index   - A new index.
     * @param reverse - Optional. Explicitly sets the transition direction.
     */
    setIndex(index: number, reverse?: boolean): void;
    /**
     * Returns the current texture index.
     */
    getIndex(): number;
    /**
     * Applies current and next textures and aspect ratios.
     *
     * @param curr - A current index.
     * @param next - A next index.
     */
    setTexture(curr: number, next: number): void;
    /**
     * Sets transition progress (0-1).
     *
     * @param progress - Progress rate.
     */
    setProgress(progress: number): void;
    /**
     * Sets material parameters.
     *
     * @param params - Parameters to update.
     */
    setParams(params: MaterialParameters): void;
    /**
     * Returns the number of textures.
     */
    getLength(): number;
    /**
     * Load sources and create textures.
     *
     * @return A promise resolved when sources are loaded.
     */
    protected loadSources(): Promise<Texture[]>;
    /**
     * Loads the video texture.
     * 2 means `HAVE_CURRENT_DATA`.
     *
     * @link https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/readyState
     *
     * @param video - A video element.
     *
     * @return A promise resolved when the texture is available.
     */
    protected loadVideo(video: HTMLVideoElement): Promise<VideoTexture>;
    /**
     * Loads the mask texture if available.
     *
     * @return A promise resolved when the texture is loaded.
     */
    protected loadMask(): Promise<void>;
    /**
     * Returns the dimension of the provided texture.
     *
     * @param texture - A Texture instance.
     *
     * @return A tuple as `[ width, height ]`.
     */
    protected getTextureDimension(texture: Texture): [number, number];
}
//# sourceMappingURL=Material.d.ts.map