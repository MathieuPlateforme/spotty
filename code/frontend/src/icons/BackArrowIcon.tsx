interface BackArrowIconProps {
  color: string;
}
export const BackArrowIcon: React.FC<BackArrowIconProps> = ({ color }) => (
  <svg width="28" height="28" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
    <path
      d="M240 424v-96c116.4 0 159.39 33.76 208 96 0-119.23-39.57-240-208-240V88L64 256z"
      fill={color}
      stroke="currentColor"
      strokeLinejoin="round"
      strokeWidth="32"
      color={color}
    />
  </svg>
);
