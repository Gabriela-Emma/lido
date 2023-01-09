import { Mesh, PerspectiveCamera, PlaneGeometry, Scene, WebGLRenderer } from 'three';
import { Material } from 'three/src/materials/Material';
import { Texture } from 'three/src/textures/Texture';
/**
 * The class for creating WebGLRenderer with a plain mesh which is responsive.
 *
 * @since 0.0.1
 */
export declare class Renderer {
    /**
     * The canvas element to render the scene to.
     */
    protected readonly canvas: HTMLCanvasElement;
    /**
     * A WebGLRenderer instance.
     */
    protected readonly renderer: WebGLRenderer;
    /**
     * A Mesh instance.
     */
    protected readonly mesh: Mesh;
    /**
     * A PerspectiveCamera instance.
     */
    protected readonly camera: PerspectiveCamera;
    /**
     * A Scene instance.
     */
    protected readonly scene: Scene;
    /**
     * A geometry.
     */
    protected readonly geometry: PlaneGeometry;
    /**
     * The ResponsiveMesh constructor.
     *
     * @param canvas   - A canvas element.
     * @param material - A Material instance.
     */
    constructor(canvas: HTMLCanvasElement, material: Material | Material[]);
    /**
     * Decode textures beforehand.
     *
     * @param textures - Textures to initialize.
     */
    decode(textures: Texture[]): void;
    /**
     * Renders the scene to the canvas.
     */
    render(): void;
    /**
     * Sets the dimension.
     *
     * @param width  - Width.
     * @param height - Height.
     */
    setSize(width: number, height: number): void;
    /**
     * Creates and initializes the renderer.
     *
     * @param canvas - A canvas element to render the scene to.
     *
     * @return A created WebGLRenderer instance.
     */
    protected createRenderer(canvas: HTMLCanvasElement): WebGLRenderer;
    /**
     * Creates a camera.
     *
     * @return A created PerspectiveCamera instance.
     */
    protected createCamera(): PerspectiveCamera;
    /**
     * Computes the view dimension so that the mesh fills up the camera.
     *
     * @param aspect - Aspect ratio.
     */
    protected computeViewDimension(aspect: number): [number, number];
}
//# sourceMappingURL=Renderer.d.ts.map