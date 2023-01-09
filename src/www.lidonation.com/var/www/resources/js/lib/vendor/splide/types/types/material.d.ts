/**
 * Variable material parameters.
 *
 * @since 0.0.1
 */
export interface MaterialParameters {
    /**
     * The intensity of the shader transition.
     * The default value is `0.5`.
     */
    intensity?: number;
    /**
     * Can control the UV offset behaviour as a vector.
     * The default value is `[ 1.0, 1.0 ]`.
     */
    uvOffset?: [number, number];
}
/**
 * Sources for textures.
 *
 * @since 0.0.1
 */
export declare type TextureSource = string | HTMLImageElement | HTMLVideoElement;
//# sourceMappingURL=material.d.ts.map