export interface ResponseServer {
    code: number;
    route?: string;
    message: string;
    data: unknown;
}

export interface UploadedFile {
    url: string;
    preview: string;
    type: string;
    bytes: number;
    format: string;
    size: string;
    private: boolean;
    uuid: string;
    token: string;
}

export interface ResponseServerData {
    status: boolean;
    error?: string;
    success?: string;
    message?: string;
    details: unknown;
}

export interface ResponseData {
    error: boolean;
    message: string;
    details: unknown;
}