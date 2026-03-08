import { Config, RouteParam, RouteParamsWithQueryOverload } from 'ziggy-js';

declare global {
    var Ziggy: Config;
    function route(): any;
    function route(name: string, params?: RouteParamsWithQueryOverload | RouteParam, absolute?: boolean, config?: Config): string;
}

export {};