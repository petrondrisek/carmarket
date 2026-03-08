import { Ref } from "vue";
import { Props } from "./PageProps";

export interface FetchComposable<T> {
    data: Ref<Props<T> | null>;
    error: Ref<string | null>;
    loading: Ref<boolean>;
}